//
//  dbModel.swift
//  smap
//
//  Created by Mathias Ratzesberger on 25.01.15.
//  Copyright (c) 2015 Mara-Consulting. All rights reserved.
//

import Foundation
import UIKit

class dbModel{
    var user : userModel = userModel( )
    var servcieURL = "https://af.ssl-secured-server.de/WebContent/service/Service.php?method=createUserbyDeviceId"
    var request : NSMutableURLRequest = NSMutableURLRequest()
    
    func serviceCall( ){
        request.URL = NSURL(string: self.servcieURL + "&DeviceId=" + user.DeviceId)
        request.HTTPMethod = "GET"
        
        NSURLConnection.sendAsynchronousRequest(request, queue: NSOperationQueue(), completionHandler:{ (response:NSURLResponse!, data: NSData!, error: NSError!) -> Void in
            var error: AutoreleasingUnsafeMutablePointer<NSError?> = nil
            let jsonResult: NSDictionary! = NSJSONSerialization.JSONObjectWithData(data, options:NSJSONReadingOptions.MutableContainers, error: error) as? NSDictionary
            
            if (jsonResult != nil) {
                // process jsonResult
                println("success")


            } else {
                // couldn't load JSON, look at error
                println("error")
            }
            
            
        })
    }
}