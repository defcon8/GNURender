using System;
using System.IO;
using System.Text;
using System.Net;
using System.Collections.Generic;
using System.Xml;

class XMLParameter
{
    public string parameter;
    public string value;
    public XMLParameter(string _parameter, string _value)
    {
        parameter = _parameter;
        value = _value;
    }
}

public sealed class XMLRPC
{

    static XMLRPC instance = null;
    static readonly object padlock = new object();

    List<XMLParameter> parameters = new List<XMLParameter>();

    private XMLRPC()
    {

    }

    private Dictionary<string, string> parseXML(string XML)
    {
        if (XML == string.Empty) return new Dictionary<string, string>(); // Catch empty response
        Dictionary<string, string> parameters = new Dictionary<string, string>();
        XmlTextReader reader = new XmlTextReader(new System.IO.StringReader(XML));
        reader.MoveToContent();
        while (reader.Read())
        {
            reader.MoveToContent();
            parameters.Add(reader.Name,reader.ReadInnerXml().ToString());
        }
        return parameters;
    }

    public Dictionary<string, string> auth()
    {
        newCall("auth");
        addParameter("authkey", Config.Instance.GetServerAuthKey());
        addParameter("osname", Config.Instance.GetOsName());
        addParameter("osbit", Config.Instance.GetOsBit());
        addParameter("osversion", Environment.OSVersion.ToString());
        addParameter("processorcount", Environment.ProcessorCount.ToString());
        addParameter("appversion", Config.Instance.GetBlenderVersion());
        addParameter("machinename", Environment.MachineName);
        string rawresult = send();
        return parseXML(rawresult);
    }

    public Dictionary<string, string> touchServer()
    {
        newCall("touchserver");
        addParameter("authkey", Config.Instance.GetServerAuthKey());
        addParameter("name", Config.Instance.GetNodeId());
        addParameter("appversion", Config.Instance.GetBlenderVersion());
        addParameter("osname", Config.Instance.GetOsName());
        addParameter("osbit", Config.Instance.GetOsBit());

        string rawresult = send();
        return parseXML(rawresult);
    }

    public Dictionary<string, string> saveLog(int taskid, string message)
    {
        newCall("savelog");
        addParameter("authkey", Config.Instance.GetServerAuthKey());
        addParameter("taskid", taskid.ToString());
        addParameter("message", message);

        string rawresult = send();
        return parseXML(rawresult);
    }

    public Dictionary<string, string> getTask()
    {
        newCall("gettask");
        addParameter("authkey", Config.Instance.GetServerAuthKey());
        string rawresult = send();
        return parseXML(rawresult);
    }

    public Dictionary<string, string> getScript(int projid)
    {
        newCall("getscript");
        addParameter("authkey", Config.Instance.GetServerAuthKey());
        addParameter("projid", projid.ToString());

        string rawresult = send();
        return parseXML(rawresult);
    }

    public Dictionary<string, string> saveBinairyData(int taskid, string localfile, string procoutput)
    {
        newCall("savebinairydata");
        addParameter("authkey", Config.Instance.GetServerAuthKey());

        //If file does not exist, then abort call.
        if (!File.Exists(localfile))
        {
            Dictionary<string, string> failedresp = new Dictionary<string, string>();
            failedresp.Add("error","File not found");
            return failedresp;
        }

        //Read data from file
        Int32 FileSize;
        byte[] rawData;

        FileStream fs = new FileStream(localfile, FileMode.Open, FileAccess.Read);
        FileSize = (Int32)fs.Length;
        rawData = new byte[FileSize];
        fs.Read(rawData, 0, FileSize);
        fs.Close();

        string encodeddata = System.Convert.ToBase64String(rawData);

        addParameter("taskid", taskid.ToString());
        addParameter("procoutput", procoutput);
        addParameter("data", encodeddata);


        string rawresult = send();
        return parseXML(rawresult);
    }

    public Dictionary<string, string> getFrameRenderResources(int projid)
    {
        newCall("getframerenderresources");
        addParameter("authkey", Config.Instance.GetServerAuthKey());
        addParameter("projid", projid.ToString());
        string rawresult = send();
        return parseXML(rawresult);
    }



    public void newCall(string action)
    {
        parameters.Clear();
        parameters.Add(new XMLParameter("action", action));
    }

    public void addParameter(string parameter, string value)
    {
        parameters.Add(new XMLParameter(parameter, value));
    }


    private string buildXML()
    {
        string result = string.Empty;
        result += "<?xml version='1.0'?><information>";
        foreach (XMLParameter param in parameters)
        {
            result += "<" + param.parameter + ">" + param.value + "</" + param.parameter + ">";
        }

        result += "</information>";
        return result;
    }

    public string send()
    {

        WebRequest req = null;
        WebResponse rsp = null;
        try
        {
            string uri = Config.Instance.GetServerURL() + "/rpc.php";
            req = WebRequest.Create(uri);
            req.Method = "POST";
            req.ContentType = "text/xml";
            StreamWriter writer = new StreamWriter(req.GetRequestStream());
            writer.WriteLine(buildXML());
            writer.Close();
            rsp = req.GetResponse();
            StreamReader sr = new StreamReader(rsp.GetResponseStream());
            string result = sr.ReadToEnd();
            sr.Close();
 
            return result;
        }
        catch (WebException webEx)
        {
            //Console.Write(webEx.Message.ToString());
            //Console.Write(webEx.StackTrace.ToString());
        }
        catch (Exception ex)
        {
           // Console.Write(ex.Message.ToString());
           // Console.Write(ex.StackTrace.ToString());
        }
        finally
        {
            if (req != null) req.GetRequestStream().Close();
            if (rsp != null) rsp.GetResponseStream().Close();
        }

        return string.Empty;
    }


    ~XMLRPC()
    {
    }

    /// <summary>
    /// Get database instance
    /// </summary>
    public static XMLRPC Instance
    {
        get
        {
            lock (padlock)
            {
                if (instance == null)
                {
                    instance = new XMLRPC();
                }
                return instance;
            }
        }
    }



}
