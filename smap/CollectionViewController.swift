//
//  CollectionViewController.swift
//  smap
//
//  Created by Mathias Ratzesberger on 21.07.15.
//  Copyright (c) 2015 Mara-Consulting. All rights reserved.
//

import UIKit

class CollectionViewController: UIViewController, UICollectionViewDataSource,UICollectionViewDelegate {

    override func viewDidLoad() {
        super.viewDidLoad()
    }
    
    override func didReceiveMemoryWarning() {
        super.didReceiveMemoryWarning()
    }
    
    func collectionView(collectionView: UICollectionView, didDeselectItemAtIndexPath indexPath: NSIndexPath) {
        
    }
    
    func collectionView(collectionView: UICollectionView, numberOfItemsInSection section: Int) -> Int {
        return 40
    }
    
    func collectionView(collectionView: UICollectionView, cellForItemAtIndexPath indexPath: NSIndexPath) -> UICollectionViewCell {
        var cell = collectionView.dequeueReusableCellWithReuseIdentifier("category", forIndexPath: indexPath) as! UICollectionViewCell
        
        return cell
    }
    
}
