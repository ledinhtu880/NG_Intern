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

        public void UpdateRawMaterialDispenser(List<string> Id_SimpleContents)
        {
            string message = "";
            try
            {
                foreach (var Id_SimpleContent in Id_SimpleContents)
                {
                    if (processContentSimpleServices.checkQuantity(Id_SimpleContent))
                    {
                        if (!processContentSimpleServices.UpdateContentSimple(Id_SimpleContent, out message) ||
                            !processContentSimpleServices.UpdateProcessContentSimple(Id_SimpleContent, out message) ||
                            !processContentSimpleServices.InsertProcessContentSimple(Id_SimpleContent, out message) ||
                            !processContentSimpleServices.UpdateRawMaterial(Id_SimpleContent, out message)
                        )
                        {
                            MessageBox.Show("Mã thùng hàng " + Id_SimpleContent + " rót thất bại.\n" + message, "Chú ý", MessageBoxButtons.OK, MessageBoxIcon.Error);
                        }
                        else
                        {
                            MessageBox.Show("Rót vào thùng mã " + Id_SimpleContent + " thành công", "Thông báo", MessageBoxButtons.OK, MessageBoxIcon.Information);
                        }
                    }
                    else
                    {
                        MessageBox.Show("Mã thùng hàng " + Id_SimpleContent + " rót thất bại. Không đủ số lượng tồn", "Thông báo", MessageBoxButtons.OK, MessageBoxIcon.Error);
                    }
                }
            }
            catch (Exception e)
            {
                MessageBox.Show("Rót thất bại.\n" + e.Message, "Chú ý", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }
        }
    }
}
