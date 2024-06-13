using NganGiang.Services.Process;
using System;
using System.Collections.Generic;
using System.Data;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace NganGiang.Controllers
{
    internal class Station402_Controller
    {
        private ProcessService402 processService;
        public Station402_Controller()
        {
            processService = new ProcessService402();
        }

        public DataTable getProcessContentSimple()
        {
            DataTable dt = processService.getProcessContentSimple();
            return dt;
        }
        public string getRFID(int id_simple_content)
        {
            return Helper.getRFID(id_simple_content);
        }
        public bool checkQuantity(int Id_ContentSimple)
        {
            return processService.checkQuantity(Id_ContentSimple);
        }
        public void Update(int Id_ContentSimple)
        {
            string message = "";
            if (!processService.UpdateContentSimple(Id_ContentSimple, out message) ||
            !processService.UpdateProcessContentSimple(Id_ContentSimple, out message) ||
            !processService.InsertProcessContentSimple(Id_ContentSimple, out message) ||
            !processService.UpdateRawMaterial(Id_ContentSimple, out message))
            {
                MessageBox.Show("Mã thùng hàng " + Id_ContentSimple + " rót thất bại.\n" + message, "Chú ý", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }
        }
        public void UpdateRawMaterialDispenser(int Id_ContentSimple)
        {
            string message = "";
            try
            {
                if (processService.checkQuantity(Id_ContentSimple))
                {
                    if (!processService.UpdateContentSimple(Id_ContentSimple, out message) ||
                        !processService.UpdateProcessContentSimple(Id_ContentSimple, out message) ||
                        !processService.InsertProcessContentSimple(Id_ContentSimple, out message) ||
                        !processService.UpdateRawMaterial(Id_ContentSimple, out message)
                    )
                    {
                        MessageBox.Show("Mã thùng hàng " + Id_ContentSimple + " rót thất bại.\n" + message, "Chú ý", MessageBoxButtons.OK, MessageBoxIcon.Error);
                    }
                }
                else
                {
                    MessageBox.Show("Mã thùng hàng " + Id_ContentSimple + " rót thất bại. Không đủ số lượng tồn", "Thông báo", MessageBoxButtons.OK, MessageBoxIcon.Error);
                }
                MessageBox.Show("Rót thành công", "Thông báo", MessageBoxButtons.OK, MessageBoxIcon.Information);
            }
            catch (Exception e)
            {
                MessageBox.Show("Rót thất bại.\n" + e.Message, "Chú ý", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }
        }
        public bool UpdateState(int id_simple_content, int state, int station)
        {
            return Helper.UpdateState(id_simple_content, state, station);
        }
    }
}
