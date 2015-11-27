//
//  ViewController.swift
//  smap
//
//  Created by Mathias Ratzesberger on 24.01.15.
//  Copyright (c) 2015 Mara-Consulting. All rights reserved.
//

import UIKit

class ViewController: UIViewController, UITableViewDataSource {

    @IBOutlet weak var UserSettingsList: UITableView!
    
    func tableView(tableView: UITableView, numberOfRowsInSection section: Int) -> Int {
        return 3
    }
    
    func tableView(tableView: UITableView, cellForRowAtIndexPath indexPath: NSIndexPath) -> UITableViewCell {
        let UserSettingsCell : UITableViewCell = UserSettingsList.dequeueReusableCellWithIdentifier("1", forIndexPath: indexPath)
        
        return UserSettingsCell
    
    }
    
    
    override func viewDidLoad() {
        super.viewDidLoad()
        

        user.getUserData(handleUpdateUserData)
//        alert(self, title: "test", message: "test" )
        
        
        // Do any additional setup after loading the view, typically from a nib.
    }

    override func didReceiveMemoryWarning() {
        super.didReceiveMemoryWarning()
        // Dispose of any resources that can be recreated.
    }
    
    func handleUpdateUserData(done:Bool){
        if (done){
//            InputUserNick.text = user.nickName
        }
    }


}

