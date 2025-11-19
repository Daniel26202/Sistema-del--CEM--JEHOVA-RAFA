import { executePetition, alertConfirm, alertError, alertSuccess } from "./funtionExecutePetition.js";
const url = "/Sistema-del--CEM--JEHOVA-RAFA/Pacientes";

//restablecer
const restablecerPattients = async (data) => {
  try {
    const result = await executePetition(url + `/restablecer/${data}`, "GET");
    if (result.ok) {
      alertSuccess(result.message);

      readPatients();
    } else throw new Error(`${result.error}`);
  } catch (error) {
    alertError("Error", error);
  }
};
