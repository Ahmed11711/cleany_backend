export const fields = [
  { key: "user_id", label: "User Id", required: 1, placeholder: "Enter User Id", type: "number", isString: false },
  { key: "transaction_id", label: "Transaction Id", required: 1, placeholder: "Enter Transaction Id", type: "text", isString: false },
  { key: "order_id", label: "Order Id", required: 1, placeholder: "Enter Order Id", type: "text", isString: false },
  { key: "amount", label: "Amount", required: 1, placeholder: "Enter Amount", type: "number", isString: false },
  { key: "type", label: "Type", required: 1, placeholder: "Enter Type", type: "select", isString: false,
      options: [
    {
        "value": "deposit",
        "label": "Deposit"
    },
    {
        "value": "payment",
        "label": "Payment"
    }
] },
  { key: "payment_method", label: "Payment Method", required: 1, placeholder: "Enter Payment Method", type: "select", isString: false,
      options: [
    {
        "value": "wallet",
        "label": "Wallet"
    },
    {
        "value": "cash",
        "label": "Cash"
    },
    {
        "value": "credit",
        "label": "Credit"
    }
] },
  { key: "status", label: "Status", required: 1, placeholder: "Enter Status", type: "select", isString: false,
      options: [
    {
        "value": "pending",
        "label": "Pending"
    },
    {
        "value": "success",
        "label": "Success"
    },
    {
        "value": "failed",
        "label": "Failed"
    }
] },
  { key: "notes", label: "Notes", required: 1, placeholder: "Enter Notes", type: "textarea", isString: false }
];