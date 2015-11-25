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
    
    private var user : cl_UserModel = cl_UserModel()
    private var servcieURLs = "https://af.ssl-secured-server.de/WebContent/service/Service.php?method=createUserbyDeviceId"
//    private var servcieURL = "http://af.mara-consulting.de/WebContent/service/Service.php?method=createUserbyDeviceId"
    private var request : NSMutableURLRequest = NSMutableURLRequest()
    
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
        
    }
    
    func getInstance( ) ->cl_DBModel{
        return cl_DBModel.Instance
    }
    
    func serviceCall( ){
        request.URL = NSURL(string: self.servcieURLs + "&DeviceId=" + user.DeviceId)
        request.HTTPMethod = "GET"
        
//        NSURLConnection.sendAsynchronousRequest(request, queue: NSOperationQueue(), completionHandler:{ (
//            
//            response, data, error) -> Void in
//            guard let data = data else { return }
//            do{
//            var res = try NSJSONSerialization.JSONObjectWithData(data, options: []) as! NSDictionary
////                if (res.) {
////                    
////                    if (result["success"]! as! String == "true"){
////                        // process jsonResult
//                        print("success")
////                    } else  {
////                        
////                        print("fail")
////                        
////                    }
////                    
////                    
////                } else {
////                    // couldn't load JSON, look at error
////                    print("error")
////                }
//            } catch {
//                    
//            }
////            var jsonResult: NSDictionary!; jsonResult = try! NSJSONSerialization.JSONObjectWithData(data!, options:NSJSONReadingOptions.MutableContainers) as? NSDictionary
//            
//            
//        })
        
        let url = self.servcieURLs + "&DeviceId=" + user.DeviceId

        
        Alamofire.request(.GET, url, parameters: nil, encoding: .JSON)
            .responseJSON { response in
                if(response.result.isFailure) {
                    NSLog("Error: \(response.result.value)")
                    print(response.result.value)
                }
                else {
                    NSLog("Success: \(url)")
                    var json_res = JSON(response.result.value!)
                    var test3 = json_res["success"].string
                    var test4 = json_res["success"].string
            }
        }
    }
}