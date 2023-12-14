using NganGiang.Services.Process;
using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace NganGiang.Controllers
{
    internal class Station408_Controller
    {
        ProcessService408 Service { get; set; }
        public Station408_Controller()
        {
            Service = new ProcessService408();
        }
        public void Show(DataGridView data)
        {
            data.DataSource = Service.ShowContentPack();
        }
        public bool Update(int id)
        {
            bool isSuccess = true;

            try
            {
                Service.UpdateWarehouse(id);
                Service.UpdateProcessContentSimple(id);
                Service.UpdateProcessContentPack(id);
            }
            catch (SqlException ex)
            {
                MessageBox.Show($"{ex.Message}", "Cảnh báo", MessageBoxButtons.OK, MessageBoxIcon.Error);
                isSuccess = false;
            }

            return isSuccess;
        }
    }
}
