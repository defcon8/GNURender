#!/bin/bash
gmcs Main.cs Archive.cs Config.cs -r:System.Data.dll -out:../node.exe
