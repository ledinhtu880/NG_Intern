using System;
using System.Collections.Generic;
using System.Diagnostics;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace NganGiang.Libs
{
    internal class PythonHandler
    {
        private static PythonHandler instance;
        private Process pythonProcess;

        internal static PythonHandler Instance
        {
            get
            {
                if (instance == null)
                    instance = new PythonHandler();
                return instance;
            }
        }

        public string RunPythonScript(string cmd, string args)
        {
            ProcessStartInfo start = new ProcessStartInfo
            {
                FileName = cmd,
                Arguments = args,
                UseShellExecute = false,
                RedirectStandardOutput = true,
                CreateNoWindow = true
            };

            using (Process process = Process.Start(start))
            {
                using (StreamReader reader = process.StandardOutput)
                {
                    string result = reader.ReadToEnd();
                    return result;
                }
            }
        }
        public Image ResizeImage(Image image, int maxWidth, int maxHeight)
        {
            float aspectRatio = (float)image.Width / image.Height;

            int calculatedWidth = Math.Min(maxWidth, (int)(maxHeight * aspectRatio));
            int calculatedHeight = Math.Min(maxHeight, (int)(maxWidth / aspectRatio));

            if (calculatedWidth > image.Width || calculatedHeight > image.Height)
            {
                calculatedWidth = image.Width;
                calculatedHeight = image.Height;
            }

            Bitmap resizedBitmap = new Bitmap(calculatedWidth, calculatedHeight);

            using (Graphics g = Graphics.FromImage(resizedBitmap))
            {
                g.DrawImage(image, 0, 0, calculatedWidth, calculatedHeight);
            }
            return resizedBitmap;
        }
        public void StopPythonScript()
        {
            if (pythonProcess != null && !pythonProcess.HasExited)
            {
                pythonProcess.Kill();
                pythonProcess.Dispose();
                pythonProcess = null;
            }
        }
    }
}
