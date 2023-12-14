using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace NganGiang.Models
{
    internal class OrderLocal
    {
        public decimal Id_OrderLocal { get; set; }
        public short Count { get; set; }
        public string? DateDilivery { get; set; }
        public bool SimpleOrPack { get; set; }
        public short MakeOrPackOrExpedition { get; set; }
        public string? Data_Start { get; set; }
        public string? Data_Fin { get; set; }
    }
}
