using NganGiang.Libs;
using NganGiang.Services.Process;
using System.Security.Permissions;

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
        public string UpdateProcessAndSimple(int id_content_simple, byte[] rfidBytes)
        {
            processServices.UpdateContainerProvided(id_content_simple);
            processServices.UpdatePedestalProvided(id_content_simple);
            processServices.UpdateRFIDProvided(id_content_simple, rfidBytes);
            return string.Empty;
        }
        public bool checkQuantityContainer(int id_content_simple)
        {
            return processServices.checkQuantityContainer(id_content_simple);
        }
        public bool checkQuantityPedestal(int id_content_simple)
        {
            return processServices.checkQuantityPedestal(id_content_simple);
        }
        public void UpdateContainerProvided(int id_content_simple)
        {
            processServices.UpdateContainerProvided(id_content_simple);
        }
        public void UpdatePedestalProvided(int id_content_simple)
        {
            processServices.UpdatePedestalProvided(id_content_simple);
        }
        public void UpdateQuantity(int quantityConsumed)
        {
            processServices.UpdateQuantityContainer(quantityConsumed);
            processServices.UpdateQuantityPedestal(quantityConsumed);
        }
        public bool UpdateStateSimple(int id_content_simple, int state, int station)
        {
            return Helper.UpdateStateSimple(id_content_simple, state, station);
        }
        public byte[] GenerateRandomBytes(int length)
        {
            return ProcessService401.GenerateRandomBytes(length);
        }
    }
}
