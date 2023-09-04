export type InitFormFromItem = (
  onInit ?: Function,
  resetOnSuccess ?: Boolean
) => void

export type OnSubmit = (
  route : String,
  redirectRoute : String,
  hasToRedirect ?: Boolean,
  data?: any,
) => void;
