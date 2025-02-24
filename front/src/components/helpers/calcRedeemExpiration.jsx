export const calcRedeemExpiration = (item) => {
  if (item.pivot["usage_status"] === "used") {
    const validity = item["usage_period"];
    const date = new Date(item.pivot["created_at"]);
    date.setHours(date.getHours() + validity);
    return date.toISOString();
  }
  return "";
}