import { Component, OnInit } from '@angular/core';
import { ProfileNameModel } from "../models/profile.model";
import { ProfileService } from "../services/profile.service";
import { Router } from "@angular/router";

@Component({
  selector: 'app-profile',
  templateUrl: './profileName.component.html',
  styleUrls: ['./profileName.component.scss'],
  //providers: [ProfileService]
})
export class ProfileNameComponent implements OnInit {

  profile: ProfileNameModel = <ProfileNameModel>{};

  constructor( private z: ProfileService, private router: Router ) {}

  ngOnInit() {
  this.getName();
  }

  getName(){
    this.z.getProfileName().subscribe((result) => {
      this.profile = result;
    });
  }

  submit(){
    this.z.saveProfileName(this.profile).subscribe((result) => {

      // If any of name or password is updated for a user, he has to login again
      this.router.navigate(['/login']);
    });
  }
}
