using NganGiang.Services.Process;
using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Documents;

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

        public byte[] GenerateQrCode(int id_content_simple)
        {
            return process407Services.GenerateQrCode(id_content_simple);
        }

        public bool IsLastStation(int id_content_simple)
        {
            return process407Services.IsLastStation(id_content_simple);
        }
        public bool IsOutOfStockContainer(int id_content_simple)
        {
            return process407Services.IsOutOfStockContainer(id_content_simple);
        }
        public bool isInternalCustomer(int id_content_simple)
        {
            return process407Services.checkCustomer(id_content_simple) == 1;
        }
        public void FreeCellDetail(int id_content_simple)
        {
            process407Services.FreeCellDetail(id_content_simple);
        }
        public void UpdateQrCodeAndState(int id_content_simple)
        {
            process407Services.UpdateQrCodeAndState(id_content_simple);
        }
        public void UpdateProcessAndOrder(int id_content_simple)
        {
            process407Services.UpdateProcessAndOrder(id_content_simple);
        }
        public void UpdateAndInsertProcessPack(int id_content_simple)
        {
            process407Services.UpdateAndInsertProcessPack(id_content_simple);
        }
        public void UpdateAndInsertProcessSimple(int id_content_simple)
        {
            process407Services.UpdateAndInsertProcessSimple(id_content_simple);
        }
        public string getRFID(int id_content_simple)
        {
            return Helper.getRFID(id_content_simple);
        }
        public bool UpdateStateSimple(int id_content_simple, int state, int station)
        {
            return Helper.UpdateStateSimple(id_content_simple, state, station);
        }
    }
}
