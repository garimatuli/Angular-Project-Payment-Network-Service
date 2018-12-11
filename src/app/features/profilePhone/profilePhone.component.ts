import {Component, OnInit, ViewChild} from '@angular/core';
import { ProfilePhoneModel} from "../models/profile.model";
import {DialogBoxComponent} from "../../dialogBox/dialogBox.component";
import {ProfileService} from "../services/profile.service";
import {Router} from "@angular/router";

import { UserInfoService } from "../../services/user-info.service";
import {AlertService} from "../../services/alert.service";

@Component({
  selector: 'app-profile-phone',
  templateUrl: './profilePhone.component.html',
  styleUrls: ['./profilePhone.component.scss']
})
export class ProfilePhoneComponent implements OnInit {

  profilePhone: ProfilePhoneModel[] = []; // array object for get call

  addedPhone: ProfilePhoneModel = <ProfilePhoneModel>{}; // Single object for post call

  @ViewChild(DialogBoxComponent) dialogBox: DialogBoxComponent;

  constructor(private w: ProfileService, private router: Router, private y: UserInfoService,
              private x: AlertService) { }

  ngOnInit() {
    this.getPhone();
  }

  getPhone() {
    this.w.getProfilePhone().subscribe((result) => {
      this.profilePhone = result.details;
    })
  }

  openAddNewPhone() {
    this.addedPhone = <ProfilePhoneModel>{};
    this.dialogBox.openDialogBox();
  }

  submit() {
    this.w.addPhone(this.addedPhone).subscribe((result) => {
      this.dialogBox.closeDialogBox();
      this.x.success("Phone number added successfully.");
      this.getPhone();
    });
  }

  deletePhone(toBeDeletedPhone:ProfilePhoneModel){

    // Delete Identifier will only work in case it is not the logged in Identifier

    if(toBeDeletedPhone.identifier != this.y.getIdentifier()) {
      this.w.deletedPhone(toBeDeletedPhone).subscribe((result) => {
        this.getPhone();
        this.x.success("Phone number deleted successfully.");
        //this.router.navigate(['/login']);
      });
    } else {
      this.x.error("Phone number cannot be deleted! User currently logged in with this number.");
    }
  }
}
