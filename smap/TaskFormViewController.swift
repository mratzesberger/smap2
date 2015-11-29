
//
//  Created by Mathias Ratzesberger on 21.07.15.
//  Copyright (c) 2015 Mara-Consulting. All rights reserved.
//
import XLForm

class TaskFormViewController : XLFormViewController {
    
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
        
        form = XLFormDescriptor()
        
        section = XLFormSectionDescriptor.formSectionWithTitle("Aufgaben")
        form.addFormSection(section)
        
        // NativeEventFormViewController
        row = XLFormRowDescriptor(tag: Tags.Task, rowType: XLFormRowDescriptorTypeButton, title: "Test Aufgabe 1")
        row.action.formSegueIdenfifier = "TaskSegue"
        section.addFormRow(row)
        
        section = XLFormSectionDescriptor.formSectionWithTitle("This form is actually an example")
        section.footerTitle = "ExamplesFormViewController.swift, Select an option to view another example"
        form.addFormSection(section)
        
        self.form = form
    }
    
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
