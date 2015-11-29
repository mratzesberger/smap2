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
    func getUserData(callback: ((done: Bool)->Void)?){
        
        let url = servcieURLs + "GetUserData"
        
        let parameters:[String : String] = [
            "DeviceId": user.DeviceId,
            "DeviceName": user.DeviceName,
            "DeviceModel": user.DeviceModel,
            "DeviceLocModel": user.DeviceLocModel,
            "DeviceSysName": user.DeviceSysName,
            "DeviceSysVersion": user.DeviceSysVersion
        ]
        
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
                    user.UserId = json_res["UserId"].stringValue
                }
                callback?(done: true)
        }
    }
    // Get User Data
    func setUserData(callback: ((done: Bool)->Void)?){
        
        let url = servcieURLs + "SetUserDataFlori"
        
        let parameters:[String : String] = [
            "UserId": user.UserId,
            "UserNick": user.nickName,
            "UserName": user.Name
        ]
        
        Alamofire.request(.POST, url, parameters: parameters, encoding: Alamofire.ParameterEncoding.URL)
            .responseJSON { response in
                if(response.result.isFailure) {
                    NSLog("Error: \(response.result.value)")
                    print(response.result.value)
                    callback?(done: false)
                }
                else {
                    NSLog("Success: \(url)")
                    var json_res = JSON(response.result.value!)
                    
                    if (json_res["success"].stringValue == "true"){
                         callback?(done: true)
                    }else{
                         callback?(done: false)
                    }
                   
                }

        }
    }

}
