﻿using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Xml.Linq;

namespace NganGiang.Models
{
    internal class ContentSimple
    {
        public decimal Id_ContentSimple { get; set; }
        public int FK_Id_RawMaterial { get; set; }
        public int Count_RawMaterial { get; set; }
        public int FK_Id_ContainerType { get; set; }
        public int Count_Container { get; set; }
        public double Price_Container { get; set; }
        public decimal FK_Id_Order { get; set; }
        public bool ContainerProvided { get; set; }
        public bool PedestalProvided { get; set; }
        public bool RFIDProvided { get; set; }
        public string RFID { get; set; }
        public bool RawMaterialProvided { get; set; }
    }
}
