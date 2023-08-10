export type InitFormFromItem = (
  onInit ?: Function,
  resetOnSuccess ?: Boolean
) => Promise<any>

export type OnSubmit = (
  route : String,
  redirectRoute : String,
  hasToRedirect ?: Boolean
) => void;
