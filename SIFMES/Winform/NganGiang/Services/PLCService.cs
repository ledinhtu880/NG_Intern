using NganGiang.Libs;
using NganGiang.Models;
using S7.Net;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

    namespace NganGiang.Services
    {
        internal class PLCService : IDisposable
        {
            private Plc plcClient;
            private int plcDB;

            public PLCService()
            {
                plcClient = new Plc(CpuType.S71500, "192.168.3.129", 0, 1);
                plcDB = 1;
                OpenConnection();
            }

            private void OpenConnection()
            {
                if (!plcClient.IsConnected)
                {
                    plcClient.Open();
                }
            }

            private void CloseConnection()
            {
                if (plcClient.IsConnected)
                {
                    plcClient.Close();
                }
            }

            public void Dispose()
            {
                CloseConnection();
            }

            public void sendTo401(int idContentSimple, int materialType, int containerType, int countContainer, string RFID)
            {
                try
                {
                    OpenConnection();
                    APIClient.sendInt(plcClient, plcDB, 0, 401);
                    APIClient.sendInt(plcClient, plcDB, 1, idContentSimple);
                    APIClient.sendInt(plcClient, plcDB, 2, materialType);
                    APIClient.sendInt(plcClient, plcDB, 3, containerType);
                    APIClient.sendInt(plcClient, plcDB, 4, countContainer);
                    APIClient.sendString(plcClient, plcDB, start_byte_for_struct.string_start_byte, RFID);
                }
                catch (PlcException ex)
                {
                    MessageBox.Show($"{ex.Message}", "Cảnh báo", MessageBoxButtons.OK, MessageBoxIcon.Error);
                }
            }

            public void updateStatus()
            {
                try
                {
                    OpenConnection();
                    APIClient.sendBool(plcClient, plcDB, 0, false);
                }
                catch (PlcException ex)
                {
                    MessageBox.Show($"{ex.Message}", "Cảnh báo", MessageBoxButtons.OK, MessageBoxIcon.Error);
                }
            }

            public bool CheckAcknowledgment()
            {
                try
                {
                    OpenConnection();
                    return APIClient.read_bool(plcClient, plcDB, 0);
                }
                catch (PlcException ex)
                {
                    MessageBox.Show($"{ex.Message}", "Cảnh báo", MessageBoxButtons.OK, MessageBoxIcon.Error);
                    return false;
                }
            }

            public string getRFIDFromPLC()
            {
                try
                {
                    OpenConnection();
                    return APIClient.read_string(plcClient, plcDB, start_byte_for_struct.string_start_byte);
                }
                catch (PlcException ex)
                {
                    MessageBox.Show($"{ex.Message}", "Cảnh báo", MessageBoxButtons.OK, MessageBoxIcon.Error);
                    return "";
                }
            }
        }
    }

