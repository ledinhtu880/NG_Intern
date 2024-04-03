using NganGiang.Services.Process;
using System.Data;

namespace NganGiang.Controllers
{
    internal class Station412_Controller
    {
        ProcessService412 service { get; set; }

        public Station412_Controller()
        {
            service = new ProcessService412();
        }

        public DataTable DisplayListOrderProcess()
        {
            return service.getProcessAt412();
        }

        public DataTable getInforContentSimpleByContentPack(int id_pack)
        {
            return service.getInforContentSimpleByContentPack(id_pack);
        }

        public void UpdateData(int id_pack)
        {
            service.UpdateProcessPackAndOrder(id_pack);
            service.UpdateProcessSimpleAndOrder(id_pack);
        }
    }
}
