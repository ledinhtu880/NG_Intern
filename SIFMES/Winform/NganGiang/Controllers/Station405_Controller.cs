using NganGiang.Services.Process;
using System.Data;
using System.Windows.Navigation;

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
        public bool checkQuantity(int id_content_simple)
        {
            return processServices.checkQuantity(id_content_simple);
        }
        public void UpdateCoverHatProvided(int id_content_simple)
        {
            processServices.UpdateCoverHatProvided(id_content_simple);
        }
        public string getRFID(int id_content_simple)
        {
            return Helper.getRFID(id_content_simple);
        }
        public bool UpdateStateSimple(int id_content_simple, int state, int station)
        {
            return Helper.UpdateStateSimple(id_content_simple, state, station);
        }
        public String Base64ToHex(string base64String)
        {
            return Helper.Base64ToHex(base64String);
        }
    }
}
