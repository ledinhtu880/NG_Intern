using NganGiang.Services.Process;

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
        public bool checkQuantity(int id_simple_content)
        {
            return processServices.checkQuantity(id_simple_content);
        }
        public string UpdateCoverHatProvided(int id_simple_content)
        {
            bool checkQuantity = processServices.checkQuantity(id_simple_content);
            if (checkQuantity == true)
            {
                processServices.UpdateCoverHatProvided(id_simple_content);
                return string.Empty;
            }
            else
            {
                return $"Số lượng nắp thùng cấp cho thùng hàng {id_simple_content} không đủ! Vui lòng thử lại sau";
            }
        }
        public string getRFID(int id_simple_content)
        {
            return Helper.getRFID(id_simple_content);
        }
        public bool UpdateState(int id_simple_content, int state, int station)
        {
            return Helper.UpdateState(id_simple_content, state, station);
        }
    }
}
