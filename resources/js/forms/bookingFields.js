export const fields = [
  { key: "user_id", label: "User Id", required: 1, placeholder: "Enter User Id", type: "number", isString: false },
  { key: "company_id", label: "Company Id", required: 1, placeholder: "Enter Company Id", type: "number", isString: false },
  { key: "service_id", label: "Service Id", required: 1, placeholder: "Enter Service Id", type: "number", isString: false },
  { key: "booking_date", label: "Booking Date", required: 1, placeholder: "Enter Booking Date", type: "text", isString: false },
  { key: "start_time", label: "Start Time", required: 1, placeholder: "Enter Start Time", type: "text", isString: false },
  { key: "hours", label: "Hours", required: 1, placeholder: "Enter Hours", type: "text", isString: false },
  { key: "end_time", label: "End Time", required: 1, placeholder: "Enter End Time", type: "text", isString: false },
  { key: "unit_price", label: "Unit Price", required: 1, placeholder: "Enter Unit Price", type: "number", isString: false },
  { key: "discount_applied", label: "Discount Applied", required: 1, placeholder: "Enter Discount Applied", type: "text", isString: false },
  { key: "total_price", label: "Total Price", required: 1, placeholder: "Enter Total Price", type: "number", isString: false },
  { key: "status", label: "Status", required: 1, placeholder: "Enter Status", type: "select", isString: false,
      options: [
    {
        "value": "pending",
        "label": "Pending"
    },
    {
        "value": "confirmed",
        "label": "Confirmed"
    },
    {
        "value": "completed",
        "label": "Completed"
    },
    {
        "value": "cancelled",
        "label": "Cancelled"
    },
    {
        "value": "on_the_way",
        "label": "On_the_way"
    },
    {
        "value": "in_progress",
        "label": "In_progress"
    }
] },
  { key: "payment_status", label: "Payment Status", required: 1, placeholder: "Enter Payment Status", type: "select", isString: false,
      options: [
    {
        "value": "unpaid",
        "label": "Unpaid"
    },
    {
        "value": "paid",
        "label": "Paid"
    },
    {
        "value": "cash_on_hand",
        "label": "Cash_on_hand"
    }
] },
  { key: "payment_method", label: "Payment Method", required: 1, placeholder: "Enter Payment Method", type: "select", isString: false,
      options: [
    {
        "value": "wallet",
        "label": "Wallet"
    },
    {
        "value": "cash_on_hand",
        "label": "Cash_on_hand"
    },
    {
        "value": "payment",
        "label": "Payment"
    }
] },
  { key: "address", label: "Address", required: 1, placeholder: "Enter Address", type: "text", isString: false },
  { key: "notes", label: "Notes", required: 1, placeholder: "Enter Notes", type: "textarea", isString: false },
  { key: "staff_id", label: "Staff Id", required: 1, placeholder: "Enter Staff Id", type: "text", isString: false },
  { key: "transaction_id", label: "Transaction Id", required: 1, placeholder: "Enter Transaction Id", type: "text", isString: false }
];