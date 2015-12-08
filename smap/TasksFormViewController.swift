
//
//  Created by Mathias Ratzesberger on 21.07.15.
//  Copyright (c) 2015 Mara-Consulting. All rights reserved.
//
import XLForm

class TasksFormViewController : XLFormViewController {
    
    private struct Tags {
        static let Task = "Task"
    }
    
    override init(nibName nibNameOrNil: String?, bundle nibBundleOrNil: NSBundle?) {
        super.init(nibName: nibNameOrNil, bundle: nibBundleOrNil)
        initializeForm()
    }
    
    required init?(coder aDecoder: NSCoder) {
        super.init(coder: aDecoder)
        initializeForm()
    }
    
    
    // MARK: Helpers
    
    func initializeForm() {
        let form : XLFormDescriptor
        var section : XLFormSectionDescriptor
        var row: XLFormRowDescriptor
        var label: UILabel
        
        label = UILabel()
        label.FAIcon = FAType.FACogs
        
        
        form = XLFormDescriptor()
        section = XLFormSectionDescriptor.formSectionWithTitle("Aufgaben")
        form.addFormSection(section)
        
        // NativeEventFormViewController
        row = XLFormRowDescriptor(tag: Tags.Task, rowType: XLFormRowDescriptorTypeButton, title: "Test Aufgabe 1Do any additional setup after loading the view, typically from a nib.")
        row.cellStyle = UITableViewCellStyle.Subtitle
        row.action.formSegueIdenfifier = "TaskSegue"
//        row.cellConfig["detailTextLabel.text"] = "test 1235"
//        row.cellConfig["detailTextLabel.color"] = UIColor.grayColor()
//        row.cellConfig["detailTextLabel.font"] = UIFont.systemFontOfSize(10)
//        row.selectorOptions = ["Apple", "Orange", "Pear"]
//        row.value = "Pear"
//        row.cellConfig["textLabel.font"] = label.font
//        row.cellConfig["textLabel.text"] = label.text
        section.addFormRow(row)
        
        section = XLFormSectionDescriptor.formSectionWithTitle("This form is actually an example")
        section.footerTitle = "ExamplesFormViewController.swift, Select an option to view another example"
        form.addFormSection(section)
        
        self.form = form
    }
//    override func tableView(tableView: UITableView, heightForRowAtIndexPath indexPath: NSIndexPath) -> CGFloat {
//        // change cell height
//            return 60.0
//    }
    override func viewDidLoad()
    {
        super.viewDidLoad()
        navigationItem.rightBarButtonItem = UIBarButtonItem(title: "", style: UIBarButtonItemStyle.Plain, target: self, action: "SettingsButtonPressed:")
        navigationItem.rightBarButtonItem!.FAIcon = FAType.FACogs
    }
    func SettingsButtonPressed(sender: UIBarButtonItem) {
        
        performSegueWithIdentifier("SettingsSegue", sender: self)
        
    }
}
