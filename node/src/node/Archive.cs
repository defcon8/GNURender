using System;
using System.IO;
using System.Diagnostics;

class Archive
{
	private string m_archivefile;
	private string m_directory;

	public Archive(string file)
	{
		m_archivefile = file;
	}

	public bool Extract(string directory)
	{
    
		bool result = false;
		m_directory = directory;
	
		//Check existance of file
		if (!File.Exists(m_archivefile)) {
			return false;
		}
	
	
		//Check existance of directory
		if (!Directory.Exists(m_directory)) {
			return false;
		}
	
		//Determinate type of archive
		switch (Path.GetExtension(m_archivefile)) {
			case ".zip":
				unZip();
				break;
		}
	
		return result;
	}

	private bool unZip()
	{
		switch (Config.Instance.GetOsName()) {
			case "Windows":
				unZipWindows();
				break;
	    
			case "Linux":
				unZipLinux();
				break;
	    
			case "OSX":
				unZipOSX();
				break;
		}
		return true;
	}

	private bool unZipWindows()
	{
		return true;    
	}

	private bool unZipLinux()
	{
		ProcessStartInfo ps = new ProcessStartInfo("unzip", "-o " + m_archivefile + " -d " + m_directory);
		ps.UseShellExecute = false;
		ps.RedirectStandardOutput = true;
		string output;
		using (Process p = Process.Start(ps)) {
			output = p.StandardOutput.ReadToEnd();
			p.WaitForExit();
			p.Close();
		}
		Console.WriteLine(output);
		return true;
	}

	private bool unZipOSX()
	{
		return true;
	}
}
