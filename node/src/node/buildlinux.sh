#!/bin/bash
gmcs Main.cs Archive.cs Config.cs xmlrpc.cs -r:System.Data.dll -out:../node.exe
