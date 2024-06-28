using NganGiang.Services.Process;
using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Documents;

namespace NganGiang.Controllers
{
    internal class Station407_Controller
    {
        private ProcessService407 process407Services { get; set; }

        public Station407_Controller()
        {
            process407Services = new ProcessService407();
        }

        public void DisplayListOrderProcess(DataGridView dgv)
        {
            process407Services.listProcessSimpleOrderLocal(dgv);
        }

        public byte[] GenerateQrCode(int id_content_simple)
        {
            return process407Services.GenerateQrCode(id_content_simple);
        }

        public bool IsLastStation(int id_content_simple)
        {
            return process407Services.IsLastStation(id_content_simple);
        }

        public bool UpdateData(int id_content_simple)
        {
            bool isSuccess = true;
            try
            {
                bool isLastStation = process407Services.IsLastStation(id_content_simple);
                bool isOutOfStockConatiner = process407Services.IsOutOfStockContainer(id_content_simple);
                if (process407Services.checkCustomer(id_content_simple) == 1)
                {
                    if (isOutOfStockConatiner)
                    {
                        process407Services.FreeCellDetail(id_content_simple);
                        if (isLastStation)
                        {
                            process407Services.UpdateProcessAndOrder(id_content_simple);
                        }
                        else
                        {
                            process407Services.UpdateAndInsertProcessSimple(id_content_simple);
                            process407Services.UpdateAndInsertProcessPack(id_content_simple);
                        }
                    }
                    else
                    {
                        isSuccess = false;
                        MessageBox.Show($"Số lượng thùng chứa trong kho 406 vẫn còn dư.", "Cảnh báo", MessageBoxButtons.OK, MessageBoxIcon.Error);
                    }
                }
                else
                {
                    process407Services.FreeCellDetail(id_content_simple);
                    if (isLastStation)
                    {
                        process407Services.UpdateQrCodeAndState(id_content_simple);
                        process407Services.UpdateProcessAndOrder(id_content_simple);
                    }
                    else
                    {
                        process407Services.UpdateAndInsertProcessSimple(id_content_simple);
                        process407Services.UpdateAndInsertProcessPack(id_content_simple);
                    }
                }
            }
            catch (SqlException ex)
            {
                MessageBox.Show($"{ex.Message}", "Cảnh báo", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }
            return isSuccess;
        }
    }
}
