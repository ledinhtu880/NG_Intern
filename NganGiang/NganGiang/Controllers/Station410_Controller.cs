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
    internal class Station410_Controller
    {
        private ProcessService410 process;
        public Station410_Controller()
        {
            process = new ProcessService410();
        }

        public DataTable getProcessAt410()
        {
            return process.getProcessAt410();
        }
        public DataTable getInforSimpleContentBySimplePack(decimal Id_ContentPack)
        {
            ContentPack contentPack = new ContentPack();
            contentPack.Id_PackContent = Id_ContentPack;
            return process.getInforSimpleContentByContentPack(contentPack);
        }

        public bool processAt410(List<decimal> listIdPackContents, out string message)
        {
            message = "Quấn màng PE thành công";
            foreach (decimal Id_PackContent in listIdPackContents)
            {
                ContentPack contentPack = new ContentPack();
                contentPack.Id_PackContent = Id_PackContent;
                if (!process.processAt410(contentPack, out message))
                {
                    message += "\nXảy ra lỗi khi xử lý Id_PackContent = " + Id_PackContent;
                    return false;
                }
            }

            return true;
        }
    }
}
