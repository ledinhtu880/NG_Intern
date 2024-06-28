using NganGiang.Services.Process;
using System;
using System.Collections;
using System.Collections.Generic;
using System.Data;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace NganGiang.Controllers
{
    internal class Station403_Controller
    {
        ProcessService403 Service { get; set; }
        public Station403_Controller()
        {
            Service = new ProcessService403();
        }
        #region Trạm 403
        public void Show(DataGridView data)
        {
            data.DataSource = Service.ShowContentSimple();
        }
        public bool checkQuantity(int id)
        {
            DataTable data = Service.GetCheckQuantity(id);

            if (data.Rows.Count > 0)
            {
                int soLuong = Convert.ToInt32(data.Rows[0]["Số lượng"]);
                int tonKho = Convert.ToInt32(data.Rows[0]["Tồn kho"]);

                if (soLuong > tonKho)
                {
                    return false;
                }
            }
            return true;
        }
        public int GetAmount(int id)
        {
            return Service.GetAmount(id);
        }
        public int GetRawMaterialID(int id)
        {
            return Service.GetRawMaterialID(id);
        }
        public void Update(int id)
        {
            int soLuong = Service.GetAmount(id);
            Service.UpdateRawMaterial(soLuong, id);
            Service.UpdateContentSimple(id);
            Service.UpdateProcessContentSimple(id);
        }
        public string getRFID(int id_content_simple)
        {
            return Helper.getRFID(id_content_simple);
        }
        public bool UpdateState(int id_content_simple, int state, int station)
        {
            return Helper.UpdateState(id_content_simple, state, station);
        }
        #endregion
    }
}
