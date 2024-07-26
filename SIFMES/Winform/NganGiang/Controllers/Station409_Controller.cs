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
        public void Update(int id)
        {
            int nextStation = Service.GetNextStation(id);

            try
            {
                if (nextStation != -1)
                {
                    Service.UpdateDetailStateCellOfPackWareHouse(id);
                    Service.UpdateProcessContentPack(id);
                    Service.UpdateProcessContentSimple(id);
                }
                else
                {
                    Service.UpdateProcessContentPack(id);
                    Service.UpdateProcessContentSimple(id);
                    Service.UpdateDetailStateCellOfPackWareHouse(id);
                    Service.UpdateOrderLocal(id);
                    if (Service.AreAllContentPacksInWareHouse(id))
                    {
                        Service.UpdateOrder(id);
                    }
                }
            }
            catch (SqlException ex)
            {
                MessageBox.Show($"{ex.Message}", "Cảnh báo", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }
        }
        public bool UpdateStatePack(int Id_ContentPack, int state, int station)
        {
            return Helper.UpdateStatePack(Id_ContentPack, state, station);
        }
    }
}
