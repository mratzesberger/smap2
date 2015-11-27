
// Permission is hereby granted, free of charge, to any person obtaining a copy
// of this software and associated documentation files (the "Software"), to deal
// in the Software without restriction, including without limitation the rights
// to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
// copies of the Software, and to permit persons to whom the Software is
// furnished to do so, subject to the following conditions:
//
// The above copyright notice and this permission notice shall be included in
// all copies or substantial portions of the Software.
//
// THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
// IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
// FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
// AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
// LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
// OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
// THE SOFTWARE.

import XLForm

class ExamplesFormViewController : XLFormViewController {
    
    private struct Tags {
        static let Name = "name"
        static let Nick = "nick"
        static let Date = "date"
    }
    
    override init(nibName nibNameOrNil: String?, bundle nibBundleOrNil: NSBundle?) {
        super.init(nibName: nibNameOrNil, bundle: nibBundleOrNil)
        initializeForm()
    }
    
    required init?(coder aDecoder: NSCoder) {
        super.init(coder: aDecoder)
        initializeForm()
    }
    
    func initializeForm() {
        
        let form : XLFormDescriptor
        var section : XLFormSectionDescriptor
        var row : XLFormRowDescriptor
        
        form = XLFormDescriptor(title: "Einstellungen")
        form.assignFirstResponderOnShow = true
        form.disabled = true
        
        section = XLFormSectionDescriptor.formSectionWithTitle("Benutzerdaten")
        section.footerTitle = "Bitte Benutzereinstellungen pflegen"
        form.addFormSection(section)
        
        
        // Name
        row = XLFormRowDescriptor(tag: Tags.Nick, rowType: XLFormRowDescriptorTypeText, title: "Nick")
        row.required = true
        section.addFormRow(row)
        
        // Name
        row = XLFormRowDescriptor(tag: Tags.Name, rowType: XLFormRowDescriptorTypeEmail, title: "Name")
        section.addFormRow(row)
        
//        // Date
//        row = XLFormRowDescriptor(tag: Tags.Date, rowType: XLFormRowDescriptorTypeDate, title: "Datum")
//        section.addFormRow(row)

        user.getUserData(handleUpdateUserData)
        
        self.form = form
        
    }
    
    func handleUpdateUserData(done:Bool){
        if (done){
            var row : XLFormRowDescriptor
            row = self.form.formRowWithTag(Tags.Nick)!
            row.value = user.nickName
            row = self.form.formRowWithTag(Tags.Name)!
            row.value = user.Name
            self.tableView.reloadData()
        }
    }
    
    func handleSetUserData(done:Bool){
        if (done){
            self.tableView.endEditing(true)
            
            let alertController = UIAlertController(title: "Erfolg", message: "Daten wurden erfolgreich geändert", preferredStyle: UIAlertControllerStyle.Alert)
            
            self.presentViewController(alertController, animated: true) {
                
            }
            dispatch_async(dispatch_get_main_queue()) { () -> Void in
                
                dispatch_after(dispatch_time(DISPATCH_TIME_NOW, Int64(1 * Double(NSEC_PER_SEC))), dispatch_get_main_queue(), { () -> Void in
                    alertController.dismissViewControllerAnimated(true, completion: nil)
                })
            }
            navigationItem.rightBarButtonItem = UIBarButtonItem(barButtonSystemItem: .Edit, target: self, action: "editPressed:")
            self.form.disabled = true
            self.tableView.reloadData()
        }else{
            let alertController = UIAlertController(title: "Fehler", message: "Ein Fehler ist beim ändern aufgetreten, bitte versuche es später noch mal.", preferredStyle: UIAlertControllerStyle.Alert)
            
            self.presentViewController(alertController, animated: true) {
                
            }
            dispatch_async(dispatch_get_main_queue()) { () -> Void in
                
                dispatch_after(dispatch_time(DISPATCH_TIME_NOW, Int64(1 * Double(NSEC_PER_SEC))), dispatch_get_main_queue(), { () -> Void in
                    alertController.dismissViewControllerAnimated(true, completion: nil)
                })
            }
        }
    }
    
    override func viewDidLoad()
    {
        super.viewDidLoad()
        navigationItem.rightBarButtonItem = UIBarButtonItem(barButtonSystemItem: .Edit, target: self, action: "editPressed:")
    }
    func editPressed(button: UIBarButtonItem)
    {
        navigationItem.rightBarButtonItem = UIBarButtonItem(barButtonSystemItem: .Save, target: self, action: "savePressed:")
        self.form.disabled = false
        self.tableView.reloadData()
    }
    func savePressed(button: UIBarButtonItem)
    {
        let validationErrors : Array<NSError> = self.formValidationErrors() as! Array<NSError>
        if (validationErrors.count > 0){
            self.showFormValidationError(validationErrors.first)
            return
        }else{
            user.Name = ((self.form.formRowWithTag(Tags.Name)!.value) as? String)!
            user.nickName = ((self.form.formRowWithTag(Tags.Nick)!.value) as? String)!
            user.setUserData(handleSetUserData)
            
        }
    }
    
}