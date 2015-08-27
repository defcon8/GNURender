using System;
using System.Data;
using System.IO;
using System.Diagnostics;
using System.Threading;
using System.Reflection;
using MySql.Data.MySqlClient;
using System.Collections.Generic;

public class Node
{
    public static MySqlDataReader Reader = null;
    public static MySqlCommand command;

    public enum TaskState : int
    {
        idle = 0,
        working = 1,
        finished = 2,
        error = 3
    };

    public struct Project
    {
        public int id;
        public string resourcedir;
        public string outputdir;
    }

    public class Task
    {
        public int taskid = -1;
        public int type = -1;
        public int projid = -1;
        public string application = "";
        public string parameters = "";
        public TaskState state = Node.TaskState.idle;
        public string procoutput = "";
        public string sourcefile = "";
        public string outputfile = "";
        public string format = "";
        public string script = "";
        public int framenr = -1;
        public bool sourceisarch = false;

    }

    public static bool CheckRenderScript(int projid)
    {
        bool result = false;
        string renderscript = string.Empty;
        Dictionary<string, string> scriptdetails = XMLRPC.Instance.getScript(projid);

        if (scriptdetails.ContainsKey("script"))
        {
            renderscript = scriptdetails["script"];
        }

        if (renderscript.Length > 0)
        {
            File.WriteAllText("resources" + Config.Instance.Slash() + "script.py", renderscript);
            result = true;
        }
        return result;
    }

    private static void WelcomeMsg()
    {
        Console.WriteLine("/----------------------------+");
        Console.WriteLine("| GNURender Node             |");
        Console.WriteLine("| v2.0 build 23-AUG-2014     |");
        Console.WriteLine("+----------------------------/");
        Console.WriteLine("Detecting environment..");
        Console.WriteLine("OS: " + Config.Instance.GetOsName() + " " + Config.Instance.GetOsBit() + " Bit");
        Console.WriteLine("Renderer: " + Config.Instance.GetBlenderVersion());
        //Config.Instance.ShowNetworkInterfaces();
    }

    public static void Main(string[] args)
    {
        Config.Instance.SetBlenderVersion(DetectBlenderVersion());
        WelcomeMsg();
        CreateApplicationFolders();

        consoleLog("Testing authentication against server..", ConsoleColor.White);
        Dictionary<string, string> response = XMLRPC.Instance.auth();

        if(!response.ContainsKey("authenticated")){
            consoleLog("Bad response from server.",ConsoleColor.Red);
        }
        else
        {
            if(response["authenticated"] == "true"){
                consoleLog("Authentication succesfull.", ConsoleColor.Green);
                ProgramLoop();
            }else{
                consoleLog("Authentication failed.", ConsoleColor.Red);
            }

        }

        

    }

    private static void CreateApplicationFolders()
    {
        string subPath;
        subPath = "resources";
        consoleLog("Creating resources folder..");
        if (!System.IO.Directory.Exists(subPath))
            System.IO.Directory.CreateDirectory(subPath);

        subPath = "output";
        consoleLog("Creating render output folder..");
        if (!System.IO.Directory.Exists(subPath))
            System.IO.Directory.CreateDirectory(subPath);
    }

    private static string FormatFrameNr(int framenr)
    {
        return framenr.ToString().PadLeft(4, '0');
    }

    private static string FormatExtension(string format)
    {
        string ext;
        switch (format)
        {
            default:
            case "PNG":
                ext = "png";
                break;
            case "JPEG":
                ext = "jpg";
                break;
        }
        return ext;
    }

    private static void CleanupOutputFolder()
    {
        System.IO.DirectoryInfo outputfolder = new DirectoryInfo("output");
        foreach (FileInfo file in outputfolder.GetFiles())
        {
            file.Delete();
        }
    }

    private static void CleanupResourcesFolder()
    {
        System.IO.DirectoryInfo outputfolder = new DirectoryInfo("resources");
        foreach (FileInfo file in outputfolder.GetFiles())
        {
            file.Delete();
        }
    }

    private static void CleanupFolders()
    {
        CleanupOutputFolder();
        CleanupResourcesFolder();
    }

    private static void ProgramLoop()
    {
        while (!Console.KeyAvailable)
        {

            consoleLog("Touch server..", ConsoleColor.Cyan);
            XMLRPC.Instance.touchServer();

            consoleLog("Sending task request to server..");
            Dictionary<string, string> taskdetails = XMLRPC.Instance.getTask();

            if (!taskdetails.ContainsKey("taskid"))
            {
                consoleLog("Server has no task for me, wait 5 sec.",ConsoleColor.Cyan);
                Thread.Sleep(5000);
            }
            else
            {
                consoleLog("Received task: " + taskdetails["taskid"], ConsoleColor.Yellow);

                CleanupFolders();

                switch (Convert.ToInt16(taskdetails["type"]))
                {
                    case 0:
                        //render individual frame
                        RenderFrame(taskdetails);
                        break;
                    case 1:
                        //merge frames to AVI
                        MergeFrames(taskdetails);
                        break;
                }
                consoleLog("Task: "+taskdetails["taskid"]+ " is finished.");
            }
        }
    }

    private static void MergeFrames(Dictionary<string, string> taskdetails)
    {
        GetResourcesFramesMerge(Convert.ToInt32(taskdetails["projid"]));
        string parameters = taskdetails["parameters"].Replace("{inputfiles}", "resources" + Config.Instance.Slash() + "frame-%04d.png");
        parameters = taskdetails["parameters"].Replace("{outputfile}", "output" + Config.Instance.Slash() + taskdetails["projid"] + ".avi");

        //Start render process
        Console.WriteLine(DateTime.Now + ": Starting ffmpeg..");
        ProcessStartInfo ps = new ProcessStartInfo(taskdetails["application"], taskdetails["parameters"]);
        ps.UseShellExecute = false;
        ps.RedirectStandardOutput = true;
        ps.RedirectStandardError = true;
        string output;
        string error;
        using (Process p = Process.Start(ps))
        {
            output = MySqlHelper.EscapeString(p.StandardOutput.ReadToEnd());
            error = MySqlHelper.EscapeString(p.StandardError.ReadToEnd());
            p.WaitForExit();
            p.Close();
        }
        // Save data
        Console.WriteLine(DateTime.Now + ": Proccess ffmpeg finished.\n");
        string renderedfile = "output" + Config.Instance.Slash() + taskdetails["projid"] + ".avi";
        //TODO : SaveTaskData(newtask.taskid, renderedfile, output + error);
    }

    private static void RenderFrame(Dictionary<string, string> taskdetails)
    {

        //Setup Resource
        GetResourcesFrameRender(taskdetails);


        string parameters = taskdetails["parameters"];

        //Setup RenderScript

        if (CheckRenderScript(Convert.ToInt32(taskdetails["projid"])))
        {
            parameters += " -P " + '\u0022' + System.Environment.CurrentDirectory + Config.Instance.Slash() + "resources" + Config.Instance.Slash() + "script.py" + '\u0022';
        }

        //Parse parameter string
        if (IsArchive(taskdetails["sourcefile"]))
        {
            //this is a archive containing a .blend file
            string blendfile = taskdetails["sourcefile"].Replace(".zip", ".blend");
            parameters = parameters.Replace("$sourcefile", '\u0022' + System.Environment.CurrentDirectory + Config.Instance.Slash() + "resources" + Config.Instance.Slash() + blendfile + '\u0022');
        }
        else
        {
            //this is a .blend
            parameters = parameters.Replace("$sourcefile", '\u0022' + System.Environment.CurrentDirectory + Config.Instance.Slash() + "resources" + Config.Instance.Slash() + taskdetails["sourcefile"] + '\u0022');
        }

        parameters = parameters.Replace("$outputfile", '\u0022' + System.Environment.CurrentDirectory + Config.Instance.Slash() + "output" + Config.Instance.Slash() + taskdetails["outputfile"] + '\u0022');
        parameters = parameters.Replace("$framenr", taskdetails["framenr"].ToString());
        parameters = parameters.Replace("$prevframe", (Convert.ToInt32(taskdetails["framenr"]) - 1).ToString());
        parameters = parameters.Replace("$format", taskdetails["format"]);

        //Start render process

        consoleLog("Starting up render process..");
        ProcessStartInfo ps = new ProcessStartInfo(Config.Instance.GetAppDir() + taskdetails["application"], parameters);
        ps.UseShellExecute = false;
        ps.RedirectStandardOutput = true;
        ps.WorkingDirectory = Config.Instance.GetAppDir();
        string output = "";
        using (Process p = Process.Start(ps))
        {
            output = MySqlHelper.EscapeString(p.StandardOutput.ReadToEnd());
            p.WaitForExit();
            p.Close();
        }
        // Save data
        consoleLog("Render finished..");
        string renderedfile = System.Environment.CurrentDirectory + Config.Instance.Slash() + "output" + Config.Instance.Slash() + taskdetails["outputfile"] + FormatFrameNr(Convert.ToInt32(taskdetails["framenr"])) + "." + FormatExtension(taskdetails["format"]);
        SaveTaskData(Convert.ToInt32(taskdetails["taskid"]), renderedfile, output);
    }

    private static string DetectBlenderVersion()
    {
        //Start render process
        ProcessStartInfo ps = new ProcessStartInfo(Config.Instance.GetAppDir() + Config.Instance.GetAppExec(), "-v");
        ps.UseShellExecute = false;
        ps.RedirectStandardOutput = true;
        string output;
        using (Process p = Process.Start(ps))
        {
            output = p.StandardOutput.ReadToEnd();
            p.WaitForExit();
            p.Close();
        }
        string[] result = output.Split(new string[] { "\n", "\r\n" }, StringSplitOptions.RemoveEmptyEntries);
        return result[0] + " (" + result[3].Trim() + ")";
    }

    private static bool IsArchive(string file)
    {
        if (Path.GetExtension(file) == ".zip")
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public static void consoleLog(string text, ConsoleColor color = ConsoleColor.White)
    {
        Console.ForegroundColor = color;
        Console.WriteLine(DateTime.Now.ToString() + ": " + text);
    }

    public static void GetResourcesFramesMerge(int projid)
    {

        // BW TODO.. use RPC


        //FileStream fs;
        //long filesize = 0;
        //byte[] rawData = new byte[0];


        //try
        //{
        //    command = cDatabase.Instance.m_Connection.CreateCommand();
        //    Console.WriteLine("Downloading frames from database..");
        //    command.CommandText = "SELECT OCTET_LENGTH(data.data), data.data FROM tasks INNER JOIN data ON tasks.dataid = data.dataid WHERE tasks.projid = " + projid + " ORDER BY tasks.framenr ASC";
        //    Reader = command.ExecuteReader();
        //    int framenr = 0;

        //    while (Reader.Read())
        //    {
        //        string filename = "resources" + Config.Instance.Slash() + "frame-" + framenr.ToString().PadLeft(4, '0') + ".png";
        //        filesize = Reader.GetInt64(0);
        //        rawData = new byte[filesize];
        //        Reader.GetBytes(1, 0, rawData, 0, (int)filesize);
        //        fs = new FileStream(filename, FileMode.OpenOrCreate, FileAccess.Write);
        //        fs.Write(rawData, 0, (int)filesize);
        //        fs.Close();
        //        framenr++;
        //    }

        //    Reader.Close();
        //    Reader.Dispose();
        //    Reader = null;
        //    command.Dispose();

        //    Console.WriteLine("Downloaded: " + framenr + " frames.");

        //}
        //catch (Exception e)
        //{
        //    Console.WriteLine(e.ToString());
        //    Config.Instance.Error(e.ToString());
        //}



    }

    public static void GetResourcesFrameRender(Dictionary<string, string> taskdetails)
    {

        FileStream fs;
        BinaryWriter bw;

        Dictionary<string, string> response = XMLRPC.Instance.getFrameRenderResources(Convert.ToInt32(taskdetails["projid"]));

        string resourcefilepath = "resources" + Config.Instance.Slash() + response["filename"];

        //Open File for writing
        fs = new FileStream(resourcefilepath, FileMode.OpenOrCreate, FileAccess.Write);
        bw = new BinaryWriter(fs);

        bw.Write(Convert.FromBase64String(response["data"]));
        bw.Flush();
        bw.Close();
        fs.Close();


        //Is the file a archive.. then unpack it
        if (Path.GetExtension(response["filename"]) == ".zip")
        {
            Archive oArchive = new Archive(resourcefilepath);
            oArchive.Extract("resources");
        }

    }

    public static void SaveLog(int taskid, string message)
    {

        XMLRPC.Instance.saveLog(taskid, message);

    }

    public static int SaveTaskData(int taskid, string filename, string processoutput)
    {
        consoleLog("Uploading data to server..");
        int state = -1;

        if (File.Exists(filename))
        {
            Dictionary<string, string> response = XMLRPC.Instance.saveBinairyData(taskid, filename, processoutput);

            switch (response["stored"])
            {
                case "true":
                    state = 2;
                    SaveLog(taskid, "Rendering complete and data saved.");
                    consoleLog("Data upload complete..", ConsoleColor.Green);
                    break;
                case "false":
                    state = 3;
                    SaveLog(taskid, "Rendering complete but server says -> save data failed!");
                    consoleLog("Data upload complete, but server answered -> save data failed!", ConsoleColor.Red);
                    break;
            }
        }
        else
        {
            //File does not exist, render failed
            //TODO: Stuur TaskFailed Call
            consoleLog("The rendered output is not found. Render process failed?",ConsoleColor.Red);
            SaveLog(taskid, "Rendering failed.");
        }
        return state;
    }

}
