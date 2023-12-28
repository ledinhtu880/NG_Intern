using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace NganGiang.Models
{
    internal class ContentPack
    {
        public decimal Id_ContentPack { get; set; }
        public int Count_Pack { get; set; }
        public double Price_Pack { get; set; }
        public decimal FK_Id_Order { get; set; }
        public bool HaveEilmPE { get; set; }
        public bool HaveNFC { get; set; }
        public string CodeNFC { get; set; }
    }
}
