using NganGiang.Libs;
using System;
using System.Data;
using System.Diagnostics;
using System.Drawing.Imaging;

namespace NganGiang.Services
{
    public class PythonService
    {
        private PythonHandler pythonHandler;
        public PythonService()
        {
            pythonHandler = new PythonHandler();
        }
        public void RunEncodeImagesInDataset(string username)
        {
            string appDirectory = AppDomain.CurrentDomain.BaseDirectory;
            string datasetPath = Path.Combine(appDirectory, "Resources", "Datasets");
            string encodingFilePath = Path.Combine(appDirectory, "Resources", "models", "encodings.txt");
            string fullPathPythonScript = Path.Combine(appDirectory, "Resources", "python", "main.py").Replace('\\', '/');
            string trainedPath = $"{datasetPath}/Trained";

            pythonHandler.RunPythonScript("python", $"\"{fullPathPythonScript}\" encode_images_in_dataset \"{datasetPath}\" \"{encodingFilePath}\" \"{trainedPath}\" \"{username}\"");
        }
        public string RunRecognition(Image imgPath)
        {
            string appDirectory = AppDomain.CurrentDomain.BaseDirectory;
            string fullPathPythonScript = Path.Combine(appDirectory, "Resources", "python", "main.py").Replace('\\', '/');
            string encodingFilePath = Path.Combine(appDirectory, "Resources", "models", "encodings.txt");

            Image resizedImage = pythonHandler.ResizeImage(imgPath, 512, 300);

            string resizedImagePath = Path.Combine("temp", "resized_image.jpg");
            resizedImage.Save(resizedImagePath, ImageFormat.Jpeg);

            string text = pythonHandler.RunPythonScript("python", $"\"{fullPathPythonScript}\" recognize_faces_out \"{resizedImagePath}\" \"{encodingFilePath}\"");
            return text;
        }
        public void StopRecognition()
        {
            pythonHandler.StopPythonScript();
        }
        public void AddFilesToDataGridView(string[] files, DataGridView dgv)
        {
            int stt = 1;
            foreach (string filePath in files)
            {
                // Thêm dòng vào DataGridView
                Image image = Image.FromFile(filePath);

                dgv.Rows.Add(stt, pythonHandler.ResizeImage(image, 512, 300), "Unknown", "", "Huấn luyện", "Xóa");
                stt++;
                DataGridViewComboBoxColumn comboBoxColumn = (DataGridViewComboBoxColumn)dgv.Columns["CorrectIdentificationName"];
                comboBoxColumn.DataSource = DisplayName();
                comboBoxColumn.DisplayMember = "Name";
                comboBoxColumn.ValueMember = "UserName";
                image.Dispose();
            }
        }
        public void ClearDataGridViewImages(DataGridView dgv)
        {
            foreach (DataGridViewRow row in dgv.Rows)
            {
                var imageCell = row.Cells["ImageIdentification"];
                if (imageCell.Value != null && imageCell.Value is Image)
                {
                    ((Image)imageCell.Value).Dispose();
                }
            }
            dgv.Rows.Clear();
        }
        public List<string> DisplayDataForSelectedDate(DateTime selectedDate, DataGridView dgv)
        {
            ClearDataGridViewImages(dgv);

            string directoryPath = @"./WrongIdentification";
            string[] files = Directory.GetFiles(directoryPath);
            List<string> filteredFiles = new List<string>();
            foreach (string filePath in files)
            {
                DateTime fileLastWriteTime = File.GetLastWriteTime(filePath);

                if (fileLastWriteTime.Date == selectedDate.Date)
                {
                    filteredFiles.Add(filePath);
                }
            }
            AddFilesToDataGridView(filteredFiles.ToArray(), dgv);

            return filteredFiles;
        }
        public List<string> DisplayDataForAll(DataGridView dgv)
        {
            ClearDataGridViewImages(dgv);

            string directoryPath = @"./WrongIdentification";
            string[] files = Directory.GetFiles(directoryPath);
            List<string> filteredFiles = new List<string>();
            foreach (string filePath in files)
            {
                filteredFiles.Add(filePath);
            }
            AddFilesToDataGridView(filteredFiles.ToArray(), dgv);
            return filteredFiles;
        }
        public DataTable DisplayName()
        {
            string appDirectory = AppDomain.CurrentDomain.BaseDirectory;
            string encodingFilePath = Path.Combine(appDirectory, "Resources", "models", "encodings.txt");
            string fullPathPythonScript = Path.Combine(appDirectory, "Resources", "python", "main.py").Replace('\\', '/');

            string input = pythonHandler.RunPythonScript("python", $"\"{fullPathPythonScript}\" load_name_in_models \"{encodingFilePath}\"");
            string query;
            if (input.Trim() == "[]")
            {
                query = $"select Name, UserName from [User]";
            }
            else
            {
                string cleanInput = input.Replace("[", "").Replace("]", "");
                string[] array = cleanInput.Split(',');
                string inClause = string.Join(",", array); // Kết hợp các phần tử thành chuỗi phân tách bằng dấu phẩy

                query = $"select Name, UserName from [User] where UserName NOT IN ({inClause})";
            }

            return DataProvider.Instance.ExecuteQuery(query);
        }
        public void DeleteAllWrongIdentification(DataGridView dgv)
        {
            string folderPath = Path.Combine(Application.StartupPath, "WrongIdentification");
            try
            {
                foreach (DataGridViewRow row in dgv.Rows)
                {
                    var imageCell = row.Cells["ImageIdentification"];
                    if (imageCell.Value != null && imageCell.Value is Image)
                    {
                        ((Image)imageCell.Value).Dispose();
                    }
                }
                dgv.Rows.Clear();

                DirectoryInfo directory = new DirectoryInfo(folderPath);
                foreach (FileInfo file in directory.GetFiles())
                {
                    file.Delete();
                }

            }
            catch (Exception ex)
            {
                MessageBox.Show("Đã xảy ra lỗi khi xóa các tệp tin: " + ex.Message);
            }
        }
    }
}
