import { Component, OnInit } from '@angular/core';
import {UserInfoService} from "../services/user-info.service";

@Component({
  selector: 'app-navigation',
  templateUrl: './navigation.component.html',
  styleUrls: ['./navigation.component.scss']
})
export class NavigationComponent implements OnInit {

  loggedUser: string;

  constructor(private ssnLocal: UserInfoService) {
  }

  ngOnInit() {
    this.loggedUser = localStorage.getItem("loggedInUser");
  }
}
