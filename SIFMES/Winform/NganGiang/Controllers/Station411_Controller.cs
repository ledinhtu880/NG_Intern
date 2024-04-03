using NganGiang.Models;
using NganGiang.Services.Process;
using System;
using System.Collections.Generic;
using System.Data;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace NganGiang.Controllers
{
    internal class Station411_Controller
    {
        private ProcessService411 service;
        public Station411_Controller()
        {
            service = new ProcessService411();
        }
        public DataTable getProcessAt411()
        {
            return service.getProcessAt411();
        }
        public DataTable getInforContentSimpleByContentPack(decimal idContentPack)
        {
            ContentPack contentPack = new ContentPack();
            contentPack.Id_ContentPack = idContentPack;
            return service.getInforContentSimpleByContentPack(contentPack);
        }
        public bool processAt411(List<decimal> listIdContentPacks, out string message)
        {
            message = "";
            foreach (decimal Id_ContentPack in listIdContentPacks)
            {
                ContentPack contentPack = new ContentPack();
                contentPack.Id_ContentPack = Id_ContentPack;
                if (!service.processAt411(contentPack, out message))
                {
                    message += "\nXảy ra lỗi khi xử lý Id_ContentPack = " + Id_ContentPack;
                    return false;
                }
            }

            return true;
        }
    }
}
