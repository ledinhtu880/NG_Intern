using NganGiang.Services.Process;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace NganGiang.Controllers
{
    internal class Station405_Controller
    {
        private ProcessService405 processServices { get; set; }

        public Station405_Controller()
        {
            processServices = new ProcessService405();
        }

        public void DisplayListOrderProcess(DataGridView dgv)
        {
            processServices.listProcessSimpleOrderLocal(dgv);
        }

        public string UpdateCoverHatProvided(int id_content_simple)
        {
            bool checkQuantity = processServices.checkQuantity(id_content_simple);
            if (checkQuantity == true)
            {
                processServices.UpdateCoverHatProvided(id_content_simple);
                return string.Empty;
            }
            else
            {
                return $"Số lượng nắp thùng cấp cho thùng hàng {id_content_simple} không đủ! Vui lòng thử lại sau";
            }
        }
    }
}
