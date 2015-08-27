using System;
using System.Net.NetworkInformation;
using System.Collections.Generic;
using System.Text;
using System.Data;
using System.IO;

public sealed class Config
{
	string mysqlhost = "";
    string appexec = "";
    string serverurl = "";
    string serverauthkey = "";
	string appdir = "";
	string nodeid = "";
	string blenderversion = "";
	int osbit = -1;
	string osname = "";
	bool errorlog = false;
	static Config instance = null;
	static readonly object padlock = new object();

	private Config()
	{
	}

	public void ShowNetworkInterfaces()
	{
		IPGlobalProperties computerProperties = IPGlobalProperties.GetIPGlobalProperties();
		NetworkInterface[] nics = NetworkInterface.GetAllNetworkInterfaces();
		Console.WriteLine("Interface information for {0}.{1}     ",
			computerProperties.HostName, computerProperties.DomainName);

		if (nics == null || nics.Length < 1) {
			Console.WriteLine("  No network interfaces found.");
			return;
		}

		Console.WriteLine("  Number of interfaces .................... : {0}", nics.Length);

		foreach (NetworkInterface adapter in nics) {
			Console.WriteLine();
			Console.WriteLine(adapter.Description);
			Console.WriteLine(String.Empty.PadLeft(adapter.Description.Length, '='));
			Console.WriteLine("  Interface type .......................... : {0}", adapter.NetworkInterfaceType);
			Console.Write("  Physical address ........................ : ");
			PhysicalAddress address = adapter.GetPhysicalAddress();
			byte[] bytes = address.GetAddressBytes();
			for (int i = 0; i < bytes.Length; i++) {
				// Display the physical address in hexadecimal.
				Console.Write("{0}", bytes[i].ToString("X2"));
				// Insert a hyphen after each byte, unless we are at the end of the
				// address.
				if (i != bytes.Length - 1) {
					Console.Write("-");
				}
			}
			Console.WriteLine();
		}
	}

	private void DetectOS()
	{

		switch (Environment.OSVersion.Platform) {
			case PlatformID.Unix:
                	    // Well, there are chances MacOSX is reported as Unix instead of MacOSX.
                	    // Instead of platform check, we'll do a feature checks (Mac specific root folders)
				if (Directory.Exists("/Applications") & Directory.Exists("/System") & Directory.Exists("/Users") & Directory.Exists("/Volumes")) {
					osname = "OSX";
				} else {
					osname = "Linux";
				}
				break;
			case PlatformID.MacOSX:
				osname = "OSX";
				break;
			default:
				osname = "Windows";
				break;
		}

		switch (IntPtr.Size) {
			case 4:
				osbit = 32;
				break;
			case 8:
				osbit = 64;
				break;
		}
	}

	public char Slash()
	{
		return System.IO.Path.DirectorySeparatorChar;
	}

	public void Error(string text)
	{
		if (errorlog) {
			string path = "errorlog.txt";
			if (File.Exists(path)) {
				File.AppendAllText(path, DateTime.Now + ": " + text + "\n");
			} else {
				File.WriteAllText(path, DateTime.Now + ": " + text + "\n");
			}
		}
	}

	private void ReadConfig()
	{
		if (!File.Exists("config.ini")) {
			Console.WriteLine("No configfile found!");
			Environment.Exit(0);
		} else {
			Console.WriteLine("Reading configfile..!");
		}
		
		StreamReader ConfigFile = new StreamReader("config.ini");
	
		while (ConfigFile.Peek() >= 0) {
			string[] words = ConfigFile.ReadLine().Split('=');
		
			switch (words[0]) {
				default:
					break;
				case "errorlog":
					SetErrorLog(words[1]);
					break;
				case "appdir":
					SetAppDir(words[1]);
					break;
                case "appexec":
                    SetAppExec(words[1]);
                    break;
				case "nodeid":
					SetNodeId(words[1]);
					break;
                case "serverurl":
                    SetServerURL(words[1]);
                    break;
                case "serverauthkey":
                    SetServerAuthKey(words[1]);
                    break;


			}
		}
	
		ConfigFile.Close();
		Console.WriteLine("Finished!");
	}

	public void SetErrorLog(string value)
	{
		errorlog = Convert.ToBoolean(value);
	}

	public void SetBlenderVersion(string value)
	{
		blenderversion = value;
	}

    public void SetServerURL(string value)
    {
        serverurl = value;
    }

    public void SetServerAuthKey(string value)
    {
        serverauthkey = value;
    }

	public void SetAppDir(string value)
	{
        if(value.Substring(value.Length) != this.Slash().ToString()){
            value += this.Slash().ToString();
        }
		appdir = value;
	}

    public void SetAppExec(string value)
    {
        appexec = value;
    }

	public void SetNodeId(string value)
	{
		nodeid = value;
	}

	public string GetBlenderVersion()
	{
		return blenderversion;
	}

	public string GetOsBit()
	{
		return osbit.ToString();
	}

	public string GetOsName()
	{
		return osname;
	}

	public string GetAppDir()
	{
		return appdir;
	}

    public string GetAppExec()
    {
        return appexec;
    }

	public string GetNodeId()
	{
		return nodeid;
	}

    public string GetServerURL()
    {
        return serverurl;
    }
    public string GetServerAuthKey()
    {
        return serverauthkey;
    }

	/// <summary>
	/// Close connection in de destrcuctor
	/// </summary>
	~Config()
	{
	}

	/// <summary>
	/// Get database instance
	/// </summary>
	public static Config Instance {
		get {
			lock (padlock) {
				if (instance == null) {
					instance = new Config();
					instance.DetectOS();
					instance.ReadConfig();
				}
				return instance;
			}
		}
	}
}
