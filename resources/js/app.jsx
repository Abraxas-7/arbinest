import "bootstrap/dist/css/bootstrap.min.css";
import "bootstrap/dist/js/bootstrap.bundle.min";

import.meta.glob(["../img/**"]);

import React from "react";
import ReactDOM from "react-dom/client";
import HelloReact from "./Components/HelloReact.jsx";

const root = ReactDOM.createRoot(document.getElementById("root"));
root.render(<HelloReact />);
