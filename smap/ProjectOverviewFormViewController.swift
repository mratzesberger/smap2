
//
//  Created by Mathias Ratzesberger on 21.07.15.
//  Copyright (c) 2015 Mara-Consulting. All rights reserved.
//
import XLForm

class ProjectOverviewFormViewController : XLFormViewController {
    
    private struct Tags {
        static let ProjectName = "ProjectName"
        static let ProjectDescription = "ProjectDescription"
    }
    
    override init(nibName nibNameOrNil: String?, bundle nibBundleOrNil: NSBundle?) {
        super.init(nibName: nibNameOrNil, bundle: nibBundleOrNil)
        user.getUserProjects(initializeForm)
//        initializeForm()
    }
    
    required init?(coder aDecoder: NSCoder) {
        super.init(coder: aDecoder)
        user.getUserProjects(initializeForm)
//        initializeForm()
    }
    
    
    // MARK: Helpers
    
    func initializeForm(done:Bool) {
        let form : XLFormDescriptor
        var section : XLFormSectionDescriptor
        var row: XLFormRowDescriptor
        
        
        form = XLFormDescriptor()
        form.disabled = false
        
        section = XLFormSectionDescriptor.formSectionWithTitle("Meine Projekte")
        form.addFormSection(section)
        
        for (_,subJson):(String, JSON) in user.Projects {
            // Project Name
            row = XLFormRowDescriptor(tag: Tags.ProjectName, rowType: XLFormRowDescriptorTypeButton, title: subJson["ProjectName"].string)
            row.cellStyle = UITableViewCellStyle.Subtitle
            row.action.formSegueIdenfifier = "ProjectSegue"
            section.addFormRow(row)
        }
//        form.addFormSection(section)
//        section = XLFormSectionDescriptor.formSectionWithTitle("Meine Projekte")
//        form.addFormSection(section)
//        for (_,subJson):(String, JSON) in user.Projects {
//            // Project Name
//            row = XLFormRowDescriptor(tag: Tags.ProjectName, rowType: XLFormRowDescriptorTypeButton, title: subJson["ProjectName"].string)
//            row.cellStyle = UITableViewCellStyle.Subtitle
//            row.action.formSegueIdenfifier = "ProjectSegue"
//            section.addFormRow(row)
//        }
        form.addFormSection(section)
        
        self.form = form
    }
    func updateForm() {
        user.getUserProjects(initializeForm)
    }
    override func prepareForSegue(segue: UIStoryboardSegue, sender: AnyObject!) {
            let vc = segue.destinationViewController as! ProjectFormViewController
            vc.delegate = self
    }
    override func viewDidLoad()
    {
        super.viewDidLoad()
    }
    override func tableView(tableView: UITableView, didSelectRowAtIndexPath indexPath: NSIndexPath) {
        
        let Project = user.Projects[indexPath.row]
        user.ProjectSelected = Project
        NSLog("Navigate to Project: \(Project)")
        performSegueWithIdentifier("ProjectSegue", sender: self)
    }

}
