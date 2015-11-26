//
//  cl_UserModel.swift
//  smap
//
//  Created by Mathias Ratzesberger on 17.04.15.
//  Copyright (c) 2015 Mara-Consulting. All rights reserved.
//

import UIKit

class cl_UserModel{
    var UserId: Int = 0
    var DeviceId: String
    var DeviceName: String
    var DeviceModel: String
    var DeviceLocModel: String
    var DeviceSysName: String
    var DeviceSysVersion: String
    var firstName: String = ""
    var lastName: String = ""
    var Name: String = ""
    var nickName: String = ""
    var email: String = ""
    private var dbModel: cl_DBModel = cl_DBModel.getInstance( )
    // id init
    init( ) {
        self.DeviceId = UIDevice.currentDevice().identifierForVendor!.UUIDString
        self.DeviceName = UIDevice.currentDevice().name
        self.DeviceModel = UIDevice.currentDevice().model
        self.DeviceLocModel = UIDevice.currentDevice().localizedModel
        self.DeviceSysName = UIDevice.currentDevice().systemName
        self.DeviceSysVersion = UIDevice.currentDevice().systemVersion
    }
    
    func getUserData( ) {
        self.dbModel.getUserData()
    }
}
