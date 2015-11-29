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
    func getUserData(url:String, parameter:[String : String], callback: ((done: Bool, response:JSON?)->Void)?){
        
        Alamofire.request(.POST, url, parameters: parameter, encoding: Alamofire.ParameterEncoding.URL)
            .responseJSON { response in
                if(response.result.isFailure) {
                    NSLog("Error: \(response.result.value)")
                    print(response.result.value)
                    callback?(done: true, response: nil)
                }
                else {
                    NSLog("Success: \(url)")
                    var json_res = JSON(response.result.value!)
                    callback?(done: true, response: json_res)
                }
                
        }
    }
    // Get User Data
    func setUserData(callback: ((done: Bool, response:JSON?)->Void)?){
        
        let url = servcieURLs + "SetUserData"
        
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
                    callback?(done: false, response: nil)
                }
                else {
                    NSLog("Success: \(url)")
                    var json_res = JSON(response.result.value!)
                    
                    if (json_res["success"].stringValue == "true"){
                        callback?(done: true, response: json_res)
                    }else{
                        callback?(done: false, response: json_res)
                    }
                   
                }

        }
    }

}
