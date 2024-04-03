using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace NganGiang.Models
{
    internal class Order
    {
        public decimal Id_Order { get; set; }
        public int FK_Id_Customer { get; set; }
        public string Date_Order { get; set; }
        public string Date_Delivery { get; set; }
        public string Date_Reception { get; set; }
        public string Note { get; set; }
        public bool SimpleOrPack { get; set; }
    }
}
