using NganGiang.Services.Process;

namespace NganGiang.Controllers
{
    internal class Station401_Controller
    {
        ProcessService401 processServices { get; set; }
        public Station401_Controller()
        {
            processServices = new ProcessService401();
        }

        public void DisplayListOrderProcess(DataGridView dgv)
        {
            processServices.listMakeContent(dgv);
        }

        public string UpdateProcessAndSimple(int id_simple_content)
        {
            processServices.UpdateContainerProvided(id_simple_content);
            processServices.UpdatePesdestalProvided(id_simple_content);
            processServices.UpdateRFIDProvided(id_simple_content);
            return string.Empty;
        }
        public string UpdateContainerProvided(int id_simple_content)
        {
            bool check = processServices.checkQuantity(id_simple_content);
            if (check == true)
            {
                processServices.UpdateContainerProvided(id_simple_content);
                return string.Empty;
            }
            else
            {
                return $"Số lượng nguyên liệu thùng chứa cấp cho thùng hàng {id_simple_content} không đủ! Vui lòng thử lại sau";
            }
        }

        public string UpdatePesdestalProvided(int id_simple_content)
        {
            bool check = processServices.checkQuantity(id_simple_content);
            if (check == true)
            {
                processServices.UpdatePesdestalProvided(id_simple_content);
                processServices.UpdateRFIDProvided(id_simple_content);
                return string.Empty;
            }
            else
            {
                return $"Số lượng nguyên liệu đế cấp cho thùng hàng {id_simple_content} không đủ! Vui lòng thử lại sau";
            }
        }
    }
}
