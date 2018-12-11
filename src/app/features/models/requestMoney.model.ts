export class RequestMoneyModel {
  ssn: number;
  amount: number;
  memo: string;
  ridentifier: string;
  details: identifierPercentage[];
}

export class identifierPercentage {
  identifier: string;
  percentage: number;
}
