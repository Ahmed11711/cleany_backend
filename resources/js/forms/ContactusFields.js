export const fields = [
  { key: "key", label: "Key", required: 1, placeholder: "Enter Key", type: "select", isString: false,
      options: [
    {
        "value": "email",
        "label": "Email"
    },
    {
        "value": "phone",
        "label": "Phone"
    },
    {
        "value": "whatsapp",
        "label": "Whatsapp"
    }
] },
  { key: "value", label: "Value", required: 1, placeholder: "Enter Value", type: "text", isString: false }
];