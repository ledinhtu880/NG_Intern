using NganGiang.Services.Process;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace NganGiang.Controllers
{
    internal class Station407_Controller
    {
        private ProcessService407 process407Services { get; set; }

        public Station407_Controller()
        {
            process407Services = new ProcessService407();
        }

        public void DisplayListOrderProcess(DataGridView dgv)
        {
            process407Services.listProcessSimpleOrderLocal(dgv);
        }

        public byte[] GenerateQrCode(int id_simple_content)
        {
            return process407Services.GenerateQrCode(id_simple_content);
        }

        public bool IsLastStation(int id_simple_content)
        {
            return process407Services.IsLastStation(id_simple_content);
        }

        public void UpdateData(int id_simple_content)
        {
            process407Services.UpdateQrCodeAndState(id_simple_content);
            bool isLastStation = process407Services.IsLastStation(id_simple_content);
            if (isLastStation == true)
            {
                process407Services.UpdateProcessAndOrder(id_simple_content);
            }
            else
            {
                process407Services.UpdateAndInsertProcessSimple(id_simple_content);
                process407Services.UpdateAndInsertProcessPack(id_simple_content);
            }
        }
    }
}
