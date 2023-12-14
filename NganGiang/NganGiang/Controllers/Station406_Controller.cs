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
    internal class Station406_Controller
    {
        private ProcessService406 service;
        public Station406_Controller()
        {
            service = new ProcessService406();
        }
        public DataTable getProcessAt406()
        {
            return service.getProcessAt406();
        }
        public DataTable getInforOrderByIdSimpleContent(decimal Id_SimpleContent)
        {
            ContentSimple contentSimple = new ContentSimple();
            contentSimple.Id_SimpleContent = Id_SimpleContent;
            return service.getInforOrderByIdSimpleContent(contentSimple);
        }
        public int getRowAndCol(out int col)
        {
            WareHouse house = service.getRowAndCol();
            col = house.numCol;
            return house.numRow;
        }
        public DataTable getLocationMatrix()
        {
            return service.getLocationMatrix();
        }

        public bool processClickStorage(List<decimal> Id_ContentSimples)
        {
            ProcessContentSimple process;
            string message = "";
            foreach (decimal Id_ContentSimple in Id_ContentSimples)
            {
                process = new ProcessContentSimple();
                process.FK_Id_ContentSimple = Id_ContentSimple;
                if (!service.updateDetailStateCellOfSimpleWareHouse(process, out message) ||
                    !service.updateProcessContentSimple(process, out message) ||
                    !service.updateOrderLocal(process, out message) ||
                    !service.updateOrder(process, out message)
                   )
                {
                    MessageBox.Show("Xảy ra lỗi với mã thùng hàng = " + process.FK_Id_ContentSimple + "\n" + message, "Chú ý", MessageBoxButtons.OK, MessageBoxIcon.Error);
                    return false;
                }
            }
            return true;
        }
        public int getStateByRowAndCol(int row, int col)
        {
            return service.getStateByRowAndCol(row, col);
        }
        public bool updateStateCellOfSimpleWareHouse(int row, int col, int state, out string message)
        {
            return service.updateStateCellOfSimpleWareHouse(row, col, state, out message);
        }
    }
}
