//
//  CollectionViewController.swift
//  smap
//
//  Created by Mathias Ratzesberger on 21.07.15.
//  Copyright (c) 2015 Mara-Consulting. All rights reserved.
//

import UIKit

class CollectionViewController: UIViewController {

    @IBOutlet var settingsButton: UIBarButtonItem!
    
    override func viewDidLoad() {
        
        settingsButton.FAIcon = FAType.FACogs
        
        super.viewDidLoad()
    }
    
    override func didReceiveMemoryWarning() {
        super.didReceiveMemoryWarning()
    }
    
}
