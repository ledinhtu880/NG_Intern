using NganGiang.Models;
using NganGiang.Services.Process;
using System;
using System.Collections.Generic;
using System.Data;
using System.Data.SqlClient;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;

namespace NganGiang.Controllers
{
    internal class Station409_Controller
    {
        ProcessService409 Service { get; set; }
        public Station409_Controller()
        {
            Service = new ProcessService409();
        }
        public void Show(DataGridView data)
        {
            data.DataSource = Service.ShowContentPack();
        }
        public DataTable getMatrix()
        {
            return Service.getLocationMatrix();
        }
        public int getRowAndCol(out int col)
        {
            WareHouse house = Service.getRowAndCol();
            col = house.numCol;
            return house.numRow;
        }
        public bool Update(int id)
        {
            bool isSuccess = true;
            int nextStation = Service.GetNextStation(id);

            if (nextStation == -1)
            {
                Service.UpdateDetailStateCellOfPackWareHouse(id);
                Service.UpdateProcessContentPack(id);
            }
            else
            {
                try
                {
                    Service.UpdateProcessContentPack(id);
                    Service.UpdateDetailStateCellOfPackWareHouse(id);
                    Service.UpdateOrderLocal(id);
                    if (Service.AreAllPackContentsInWareHouse(id))
                    {
                        Service.UpdateOrder(id);
                    }
                }
                catch (SqlException ex)
                {
                    MessageBox.Show($"{ex.Message}", "Cảnh báo", MessageBoxButtons.OK, MessageBoxIcon.Error);
                    isSuccess = false;
                }
            }

            return isSuccess;
        }
    }
}
