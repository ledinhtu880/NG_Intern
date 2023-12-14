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
        public DataTable getInforSimpleContentByContentPack(decimal idPackContent)
        {
            ContentPack contentPack = new ContentPack();
            contentPack.Id_PackContent = idPackContent;
            return service.getInforSimpleContentByContentPack(contentPack);
        }
        public bool processAt411(List<decimal> listIdPackContents, out string message)
        {
            message = "";
            foreach (decimal Id_PackContent in listIdPackContents)
            {
                ContentPack contentPack = new ContentPack();
                contentPack.Id_PackContent = Id_PackContent;
                if (!service.processAt411(contentPack, out message))
                {
                    message += "\nXảy ra lỗi khi xử lý Id_PackContent = " + Id_PackContent;
                    return false;
                }
            }

            return true;
        }
    }
}
