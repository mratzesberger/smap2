//
//  ViewController.swift
//  smap
//
//  Created by Mathias Ratzesberger on 24.01.15.
//  Copyright (c) 2015 Mara-Consulting. All rights reserved.
//

import UIKit

class ViewController: UIViewController {

    @IBOutlet var dynamicList: UIView!
    
    override func viewDidLoad() {
        super.viewDidLoad()
        
        let test = cl_DBModel()
        test.serviceCall()
        
        alert(self, title: "test", message: "test" )
        
        // Do any additional setup after loading the view, typically from a nib.
    }

    override func didReceiveMemoryWarning() {
        super.didReceiveMemoryWarning()
        // Dispose of any resources that can be recreated.
    }
    



}

