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
        private ProcessService402 processContentSimpleServices;
        public Station402_Controller()
        {
            processContentSimpleServices = new ProcessService402();
        }

        public DataTable getProcessContentSimple()
        {
            DataTable dt = processContentSimpleServices.getProcessContentSimple();
            return dt;
        }

        public void UpdateRawMaterialDispenser(List<string> Id_ContentSimples)
        {
            string message = "";
            try
            {
                foreach (var Id_ContentSimple in Id_ContentSimples)
                {
                    if (processContentSimpleServices.checkQuantity(Id_ContentSimple))
                    {
                        if (!processContentSimpleServices.UpdateContentSimple(Id_ContentSimple, out message) ||
                            !processContentSimpleServices.UpdateProcessContentSimple(Id_ContentSimple, out message) ||
                            !processContentSimpleServices.InsertProcessContentSimple(Id_ContentSimple, out message) ||
                            !processContentSimpleServices.UpdateRawMaterial(Id_ContentSimple, out message)
                        )
                        {
                            MessageBox.Show("Mã thùng hàng " + Id_ContentSimple + " rót thất bại.\n" + message, "Chú ý", MessageBoxButtons.OK, MessageBoxIcon.Error);
                        }
                    }
                    else
                    {
                        MessageBox.Show("Mã thùng hàng " + Id_ContentSimple + " rót thất bại. Không đủ số lượng tồn", "Thông báo", MessageBoxButtons.OK, MessageBoxIcon.Error);
                    }
                }
                MessageBox.Show("Rót thành công", "Thông báo", MessageBoxButtons.OK, MessageBoxIcon.Information);
            }
            catch (Exception e)
            {
                MessageBox.Show("Rót thất bại.\n" + e.Message, "Chú ý", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }
        }
    }
}
