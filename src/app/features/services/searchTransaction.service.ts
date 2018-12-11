import { HttpClient } from "@angular/common/http";
import {UserInfoService} from "../../services/user-info.service";
import {Injectable} from "@angular/core";
import {Observable} from "rxjs";

@Injectable()

export class searchTransactionService {

  constructor(private http: HttpClient, private x: UserInfoService) {
  }

  getTransaction(searchTransactions) {
    let currentSSN = this.x.getSSN();
    return <Observable<any>>this.http.get("http://localhost/dbms/getSearch?ssn="
      +currentSSN+"&identifier="+searchTransactions.identifier+"&sdate="
      +searchTransactions.startDate+"&edate="+searchTransactions.endDate);
  }
}

