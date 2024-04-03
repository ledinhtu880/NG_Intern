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
        public DataTable getInforContentSimpleBySimplePack(decimal Id_ContentPack)
        {
            ContentPack contentPack = new ContentPack();
            contentPack.Id_ContentPack = Id_ContentPack;
            return process.getInforContentSimpleByContentPack(contentPack);
        }

        public bool processAt410(List<decimal> listIdContentPacks, out string message)
        {
            message = "Quấn màng PE thành công";
            foreach (decimal Id_ContentPack in listIdContentPacks)
            {
                ContentPack contentPack = new ContentPack();
                contentPack.Id_ContentPack = Id_ContentPack;
                if (!process.processAt410(contentPack, out message))
                {
                    message += "\nXảy ra lỗi khi xử lý gói hàng số = " + Id_ContentPack;
                    return false;
                }
            }
            return true;
        }
    }
}
