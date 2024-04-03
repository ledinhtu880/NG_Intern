using NganGiang.Libs;
using NganGiang.Services;
using NganGiang.Services.Process;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace NganGiang.Controllers
{
    internal class PythonController
    {
        private PythonService service;
        public PythonController()
        {
            service = new PythonService();
        }
        public void RunEncodeImagesInDataset(string username)
        {
            try
            {
                service.RunEncodeImagesInDataset(username);
            }
            catch (Exception ex)
            {
                MessageBox.Show($"An error occurred: {ex.Message}");
            }
        }
        public string RunRecognition(Image imgPath)
        {
            try
            {
                return service.RunRecognition(imgPath);
            }
            catch (Exception ex)
            {
                Console.WriteLine($"An error occurred: {ex.Message}");
                return "Unknown";
            }
        }
        public void StopRecognition()
        {
            service.StopRecognition();
        }
        public List<string> DisplayDataForSelectedDate(DateTime selectedDate, DataGridView dgv)
        {
            return service.DisplayDataForSelectedDate(selectedDate, dgv);
        }
        public List<string> DisplayDataForAll(DataGridView dgv)
        {
            return service.DisplayDataForAll(dgv);
        }
        public void DeleteAllWrongIdentification(DataGridView dgv)
        {
            service.DeleteAllWrongIdentification(dgv);
        }
    }
}
