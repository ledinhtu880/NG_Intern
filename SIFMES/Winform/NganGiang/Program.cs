﻿namespace NganGiang
{
    internal static class Program
    {
        /// <summary>
        ///  The main entry point for the application.
        /// </summary>
        [STAThread]
        static void Main()
        {
            // To customize application configuration such as set high DPI settings or default font,
            // see https://aka.ms/applicationconfiguration.
            ApplicationConfiguration.Initialize();
            DeleteTempFolder();
            CreateWrongIdentificationFolder();
            Application.Run(new frmLogin());
        }
        private static void DeleteTempFolder()
        {
            string tempFolderPath = Path.Combine(Application.StartupPath, "temp");

            try
            {
                if (Directory.Exists(tempFolderPath))
                {
                    Directory.Delete(tempFolderPath, true);
                }
            }
            catch (Exception ex)
            {
                MessageBox.Show("Không thể xóa thư mục temp: " + ex.Message, "Lỗi", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }
        }
        private static void CreateWrongIdentificationFolder()
        {
            string folderPath = Path.Combine(Application.StartupPath, "WrongIdentification");
            try
            {
                if (!Directory.Exists(folderPath))
                {
                    Directory.CreateDirectory(folderPath);
                }
            }
            catch (Exception ex)
            {
                MessageBox.Show(ex.Message, "Lỗi", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }
        }
    }
}