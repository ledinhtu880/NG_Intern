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
        public string UpdateProcessAndSimple(int id_simple_content, byte[] rfidBytes)
        {
            processServices.UpdateContainerProvided(id_simple_content);
            processServices.UpdatePedestalProvided(id_simple_content);
            processServices.UpdateRFIDProvided(id_simple_content, rfidBytes);
            return string.Empty;
        }
        public bool checkQuantityContainer(int id_simple_content)
        {
            return processServices.checkQuantityContainer(id_simple_content);
        }
        public bool checkQuantityPedestal(int id_simple_content)
        {
            return processServices.checkQuantityPedestal(id_simple_content);
        }
        public void UpdateContainerProvided(int id_simple_content)
        {
            processServices.UpdateContainerProvided(id_simple_content);
        }
        public void UpdatePedestalProvided(int id_simple_content)
        {
            processServices.UpdatePedestalProvided(id_simple_content);
        }
        public void UpdateQuantity(int quantityConsumed)
        {
            processServices.UpdateQuantityContainer(quantityConsumed);
            processServices.UpdateQuantityPedestal(quantityConsumed);
        }
        public bool UpdateState(int id_simple_content, int state)
        {
            return processServices.UpdateState(id_simple_content, state);
        }
        public byte[] GenerateRandomBytes(int length)
        {
            return ProcessService401.GenerateRandomBytes(length);
        }
    }
}
