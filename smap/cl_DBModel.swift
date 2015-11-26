//
//  cl_DBModel.swift
//  smap
//
//  Created by Mathias Ratzesberger on 17.04.15.
//  Copyright (c) 2015 Mara-Consulting. All rights reserved.
//

import UIKit
import Alamofire

class cl_DBModel{
    
    /////////////////////////////////////////////////////////
    // Private Attributes
    /////////////////////////////////////////////////////////

    // Singleton Instance
    private static let Instance: cl_DBModel = cl_DBModel()
    
    /////////////////////////////////////////////////////////
    // Public Attributes
    /////////////////////////////////////////////////////////

    /////////////////////////////////////////////////////////
    // Private Methods
    /////////////////////////////////////////////////////////

    /////////////////////////////////////////////////////////
    // Public Methods
    /////////////////////////////////////////////////////////
    
    init() {
//        self.user  = cl_UserModel()
    }
    
    static func getInstance( ) ->cl_DBModel{
        return cl_DBModel.Instance
    }

    
    /////////////////////////////////////////////////////////
    // Public Service Methods
    /////////////////////////////////////////////////////////
    
    // Get User Data
    func getUserData( ){
        
        let url = servcieURLs + "GetUserData"
        
        let parameters:[String : String] = [
            "DeviceId": user.DeviceId,
            "DeviceName": user.DeviceName,
            "DeviceModel": user.DeviceModel,
            "DeviceLocModel": user.DeviceLocModel,
            "DeviceSysName": user.DeviceSysName,
            "DeviceSysVersion": user.DeviceSysVersion
        ]
        //        let parameters = [user.DeviceId,user.DeviceName,user.DeviceModel,user.DeviceLocModel,user.DeviceSysName,user.DeviceSysVersion]
        
        Alamofire.request(.POST, url, parameters: parameters, encoding: Alamofire.ParameterEncoding.URL)
            .responseJSON { response in
                if(response.result.isFailure) {
                    NSLog("Error: \(response.result.value)")
                    print(response.result.value)
                }
                else {
                    NSLog("Success: \(url)")
                    var json_res = JSON(response.result.value!)
                    
                    user.nickName = json_res["UserNick"].stringValue
                    user.Name = json_res["UserName"].stringValue
                    user.UserId = json_res["UserId"].intValue
                }
        }
    }
    

}
